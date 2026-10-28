<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Services\AktivitasService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request, AktivitasService $aktivitas)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $pengguna = Pengguna::query()
            ->where('email', $credentials['email'])
            ->first();

        $passwordTersimpan = $pengguna?->password;
        $passwordSudahHash = $passwordTersimpan !== null
            && password_get_info($passwordTersimpan)['algoName'] !== 'unknown';
        $passwordValid = $pengguna !== null && (
            $passwordSudahHash
                ? password_verify($credentials['password'], $passwordTersimpan)
                : hash_equals((string) $passwordTersimpan, $credentials['password'])
        );

        if (!$passwordValid) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password yang kamu masukkan salah.',
            ]);
        }

        if (!$passwordSudahHash || Hash::needsRehash($passwordTersimpan)) {
            $pengguna->password = Hash::make($credentials['password']);
            $pengguna->save();
        }

        Auth::login($pengguna);
        $request->session()->regenerate();
        $aktivitas->catat('Login ke Minderly');

        return redirect()->intended(route('dashboard'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request, AktivitasService $aktivitas)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:pengguna,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $pengguna = Pengguna::create([
            'nama' => $data['nama'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($pengguna);
        $request->session()->regenerate();
        $aktivitas->catat('Membuat akun Minderly');

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request, AktivitasService $aktivitas)
    {
        $aktivitas->catat('Logout dari Minderly');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Kamu berhasil keluar dari akun.');
    }
}