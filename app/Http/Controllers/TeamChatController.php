<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamMessage;
use App\Services\AktivitasService;
use Illuminate\Http\Request;

class TeamChatController extends Controller
{
    public function index(int $teamId)
    {
        $team = $this->accessibleTeam($teamId);
        $messages = TeamMessage::query()
            ->with('user')
            ->where('team_id', $team->id)
            ->latest('id')
            ->limit(100)
            ->get()
            ->reverse()
            ->values();

        return view('teams.chat', compact('team', 'messages'));
    }

    public function store(Request $request, int $teamId, AktivitasService $aktivitas)
    {
        $team = $this->accessibleTeam($teamId);
        $data = $request->validate([
            'message' => ['required', 'string', 'max:5000'],
        ]);

        TeamMessage::create([
            'team_id' => $team->id,
            'user_id' => auth()->id(),
            'message' => trim($data['message']),
        ]);

        $aktivitas->catat('Mengirim pesan di chat tim: ' . $team->name, (int) auth()->id());

        return redirect()->to(route('teams.chat.index', $team->id) . '#chat');
    }

    private function accessibleTeam(int $teamId): Team
    {
        return Team::query()
            ->whereKey($teamId)
            ->where(function ($query) {
                $query->where('owner_id', auth()->id())
                    ->orWhereHas('members', function ($members) {
                        $members->where('user_id', auth()->id());
                    });
            })
            ->firstOrFail();
    }
}