<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamInvitation;
use App\Models\Pengguna;
use App\Mail\TeamInvitationMail;
use App\Services\AktivitasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::withCount('members')
            ->where(function ($query) {
                $query->where('owner_id', auth()->id())
                    ->orWhereHas('members', function ($members) {
                        $members->where('user_id', auth()->id());
                    });
            })
            ->latest()
            ->get();

        $totalTim = $teams->count();
        $totalAnggota = $teams->sum('members_count');

        return view('teams.index', compact(
            'teams',
            'totalTim',
            'totalAnggota'
        ));
    }

    
public function create()
{
    return view('teams.create');
}

    public function store(Request $request, AktivitasService $aktivitas)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama tim wajib diisi.',
            'name.max' => 'Nama tim maksimal 100 karakter.',
        ]);

        // Gunakan pengguna yang sedang login.
        // Jika belum login, gunakan pengguna pertama di tabel users.
        $ownerId = auth()->id();

        if (!$ownerId) {
            return back()
                ->withInput()
                ->withErrors([
                    'name' => 'Tim tidak dapat dibuat karena belum ada pengguna di tabel users.',
                ]);
        }

        DB::transaction(function () use ($validated, $ownerId) {
            $team = Team::create([
                ...$validated,
                'owner_id' => $ownerId,
            ]);

            $team->members()->create([
                'user_id' => $ownerId,
                'role' => 'owner',
            ]);
        });

        $aktivitas->catat('Membuat tim: ' . $validated['name'], $ownerId);

        return redirect()
            ->route('teams.index')
            ->with('success', 'Tim berhasil dibuat.');
    }

    public function show(int $teamId)
    {
        $team = $this->visibleTeam($teamId);
        $bolehKelolaAnggota = (int) $team->owner_id === (int) auth()->id();
        $undanganTertunda = $bolehKelolaAnggota
            ? $team->invitations()->whereNull('accepted_at')->where('expires_at', '>', now())->latest()->get()
            : collect();

        return view('teams.show', compact('team', 'bolehKelolaAnggota', 'undanganTertunda'));
    }

    public function addMember(Request $request, int $teamId, AktivitasService $aktivitas)
    {
        $team = $this->ownedTeam($teamId);
        $data = $request->validate([
            'email' => ['required', 'email', 'max:100', Rule::exists('pengguna', 'email')],
        ], [
            'email.exists' => 'Akun dengan email tersebut belum terdaftar.',
        ]);

        $pengguna = Pengguna::query()->where('email', $data['email'])->firstOrFail();

        if ((int) $pengguna->id_pengguna === (int) $team->owner_id) {
            return back()->withErrors(['email' => 'Pemilik tim sudah menjadi anggota.']);
        }

        $anggotaSudahAda = $team->members()
            ->where('user_id', $pengguna->id_pengguna)
            ->exists();

        if ($anggotaSudahAda) {
            return back()->withErrors(['email' => 'Pengguna tersebut sudah menjadi anggota tim.']);
        }

        $team->members()->create([
            'user_id' => $pengguna->id_pengguna,
            'role' => 'member',
        ]);

        $aktivitas->catat('Menambahkan anggota ke tim: ' . $team->name, (int) auth()->id());

        return redirect()
            ->route('teams.show', $team->id)
            ->with('success', $pengguna->nama . ' berhasil ditambahkan ke tim.');
    }

    public function removeMember(int $teamId, int $memberId, AktivitasService $aktivitas)
    {
        $team = $this->ownedTeam($teamId);

        if ($memberId === (int) $team->owner_id) {
            return back()->withErrors(['anggota' => 'Pemilik tim tidak dapat dihapus dari tim.']);
        }

        $anggota = $team->members()
            ->where('user_id', $memberId)
            ->firstOrFail();
        $namaAnggota = $anggota->user?->nama ?? 'Pengguna';
        $anggota->delete();

        $aktivitas->catat('Menghapus anggota dari tim: ' . $team->name, (int) auth()->id());

        return redirect()
            ->route('teams.show', $team->id)
            ->with('success', $namaAnggota . ' berhasil dihapus dari tim.');
    }

    public function sendInvitation(Request $request, int $teamId, AktivitasService $aktivitas)
    {
        $team = $this->ownedTeam($teamId);
        $data = $request->validate([
            'email' => ['required', 'email', 'max:100'],
        ]);
        $email = strtolower($data['email']);

        $pengguna = Pengguna::query()->whereRaw('LOWER(email) = ?', [$email])->first();
        if ($pengguna && ((int) $pengguna->id_pengguna === (int) $team->owner_id
            || $team->members()->where('user_id', $pengguna->id_pengguna)->exists())) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Pengguna tersebut sudah menjadi anggota tim.']);
        }

        TeamInvitation::query()
            ->where('team_id', $team->id)
            ->whereRaw('LOWER(email) = ?', [$email])
            ->whereNull('accepted_at')
            ->delete();

        $token = Str::random(64);
        $invitation = TeamInvitation::create([
            'team_id' => $team->id,
            'email' => $email,
            'token_hash' => hash('sha256', $token),
            'invited_by' => auth()->id(),
            'expires_at' => now()->addDays(7),
        ]);

        $inviteUrl = route('teams.invitations.show', ['token' => $token]);

        try {
            Mail::to($email)->send(new TeamInvitationMail($team, auth()->user(), $inviteUrl));
        } catch (Throwable $exception) {
            $invitation->delete();
            report($exception);

            return back()
                ->withInput()
                ->withErrors(['email' => 'Email undangan gagal dikirim. Periksa konfigurasi mail aplikasi.']);
        }

        $aktivitas->catat('Mengirim undangan ke tim: ' . $team->name, (int) auth()->id());

        $pesanSukses = config('mail.default') === 'log'
            ? 'Undangan dibuat dan tercatat di log email. Atur SMTP untuk mengirimkannya ke inbox.'
            : 'Undangan berhasil dikirim ke ' . $email . '.';

        return redirect()
            ->route('teams.show', $team->id)
            ->with('success', $pesanSukses);
    }

    public function showInvitation(string $token)
    {
        $invitation = $this->validInvitation($token);
        abort_unless(
            hash_equals(strtolower($invitation->email), strtolower(auth()->user()->email)),
            403,
            'Masuk menggunakan alamat email yang menerima undangan.'
        );

        return view('teams.invitation', compact('invitation'));
    }

    public function acceptInvitation(string $token, AktivitasService $aktivitas)
    {
        $invitation = $this->validInvitation($token);
        abort_unless(
            hash_equals(strtolower($invitation->email), strtolower(auth()->user()->email)),
            403,
            'Masuk menggunakan alamat email yang menerima undangan.'
        );

        DB::transaction(function () use ($invitation) {
            $invitation->team->members()->firstOrCreate(
                ['user_id' => auth()->id()],
                ['role' => 'member']
            );

            $invitation->forceFill(['accepted_at' => now()])->save();
        });

        $aktivitas->catat('Bergabung ke tim melalui undangan: ' . $invitation->team->name, (int) auth()->id());

        return redirect()
            ->route('teams.show', $invitation->team_id)
            ->with('success', 'Kamu berhasil bergabung ke tim ' . $invitation->team->name . '.');
    }

    private function visibleTeam(int $teamId): Team
    {
        return Team::query()
            ->with('members.user')
            ->whereKey($teamId)
            ->where(function ($query) {
                $query->where('owner_id', auth()->id())
                    ->orWhereHas('members', function ($members) {
                        $members->where('user_id', auth()->id());
                    });
            })
            ->firstOrFail();
    }

    private function ownedTeam(int $teamId): Team
    {
        return Team::query()
            ->whereKey($teamId)
            ->where('owner_id', auth()->id())
            ->firstOrFail();
    }

    private function validInvitation(string $token): TeamInvitation
    {
        $invitation = TeamInvitation::query()
            ->with('team')
            ->where('token_hash', hash('sha256', $token))
            ->firstOrFail();

        abort_if($invitation->accepted_at, 410, 'Undangan ini sudah digunakan.');
        abort_if($invitation->expires_at->isPast(), 410, 'Undangan ini sudah kedaluwarsa.');

        return $invitation;
    }
}
