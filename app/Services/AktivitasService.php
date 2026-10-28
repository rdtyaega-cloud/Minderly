<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AktivitasService
{
    public function catat(string $deskripsi, ?int $idPengguna = null): void
    {
        DB::table('log_aktivitas')->insert([
            'id_pengguna' => $idPengguna ?? auth()->id(),
            'aktivitas' => Str::limit($deskripsi, 255, ''),
            'waktu' => now(),
        ]);
    }
}