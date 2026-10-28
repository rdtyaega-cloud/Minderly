<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeamChatController;
use App\Http\Controllers\KalenderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengaturanAkunController;
use App\Http\Controllers\RiwayatAktivitasController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TugasController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:6,1')
        ->name('login.process');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])
        ->name('notifications.index');
    Route::get('/pengaturan-akun', [PengaturanAkunController::class, 'index'])
        ->name('account.index');
    Route::put('/pengaturan-akun', [PengaturanAkunController::class, 'update'])
        ->name('account.update');
    Route::get('/riwayat-aktivitas', [RiwayatAktivitasController::class, 'index'])
        ->name('activity.index');
    Route::get('/kalender', [KalenderController::class, 'index'])
        ->name('calendar.index');

    Route::get('/tugas', [TugasController::class, 'index']);
    Route::get('/tugas/tambah', [TugasController::class, 'create']);
    Route::post('/tugas/simpan', [TugasController::class, 'store']);
    Route::get('/tugas/edit/{id}', [TugasController::class, 'edit']);
    Route::put('/tugas/update/{id}', [TugasController::class, 'update']);
    Route::delete('/tugas/hapus/{id}', [TugasController::class, 'destroy']);

    Route::get('/teams', [TeamController::class, 'index'])
        ->name('teams.index');
    Route::get('/teams/create', [TeamController::class, 'create'])
        ->name('teams.create');
    Route::post('/teams', [TeamController::class, 'store'])
        ->name('teams.store');
    Route::get('/teams/{team}', [TeamController::class, 'show'])
        ->whereNumber('team')
        ->name('teams.show');
    Route::post('/teams/{team}/members', [TeamController::class, 'addMember'])
        ->whereNumber('team')
        ->name('teams.members.store');
    Route::post('/teams/{team}/invitations', [TeamController::class, 'sendInvitation'])
        ->whereNumber('team')
        ->name('teams.invitations.store');
    Route::get('/teams/invitations/{token}', [TeamController::class, 'showInvitation'])
        ->name('teams.invitations.show');
    Route::post('/teams/invitations/{token}', [TeamController::class, 'acceptInvitation'])
        ->name('teams.invitations.accept');
    Route::delete('/teams/{team}/members/{member}', [TeamController::class, 'removeMember'])
        ->whereNumber(['team', 'member'])
        ->name('teams.members.destroy');
    Route::get('/teams/{team}/chat', [TeamChatController::class, 'index'])
        ->whereNumber('team')
        ->name('teams.chat.index');
    Route::post('/teams/{team}/chat', [TeamChatController::class, 'store'])
        ->whereNumber('team')
        ->name('teams.chat.store');
});

