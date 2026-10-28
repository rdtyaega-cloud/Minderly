<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class RiwayatAktivitasController extends Controller
{
    public function index()
    {
        $aktivitas = DB::table('log_aktivitas')
            ->leftJoin('pengguna', 'pengguna.id_pengguna', '=', 'log_aktivitas.id_pengguna')
            ->where('log_aktivitas.id_pengguna', auth()->id())
            ->select('log_aktivitas.id_log', 'log_aktivitas.aktivitas', 'log_aktivitas.waktu', 'pengguna.nama')
            ->orderByDesc('log_aktivitas.waktu')
            ->orderByDesc('log_aktivitas.id_log')
            ->paginate(25);

        return view('riwayat-aktivitas.index', compact('aktivitas'));
    }
}