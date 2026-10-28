<?php

namespace App\Http\Controllers;

use App\Services\AktivitasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PengaturanAkunController extends Controller
{
    public function index(Request $request)
    {
        return view('pengaturan-akun.index', [
            'pengguna' => $request->user(),
        ]);
    }

    public function update(Request $request, AktivitasService $aktivitas)
    {
        $pengguna = $request->user();
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:100',
                Rule::unique('pengguna', 'email')->ignore($pengguna->id_pengguna, 'id_pengguna'),
            ],
            'current_password' => ['required_with:password', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $pengguna->nama = $data['nama'];
        $pengguna->email = $data['email'];
        if (!empty($data['password'])) {
            $pengguna->password = Hash::make($data['password']);
        }
        $pengguna->save();

        $aktivitas->catat('Memperbarui pengaturan akun', (int) $pengguna->id_pengguna);

        return redirect()
            ->route('account.index')
            ->with('success', 'Pengaturan akun berhasil diperbarui.');
    }

}