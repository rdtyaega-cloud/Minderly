<?php

namespace App\Http\Controllers;

use App\Services\NotifikasiService;

class NotifikasiController extends Controller
{
    public function index(NotifikasiService $notifikasiService)
    {
        $notifikasi = $notifikasiService->semua();
        $jumlahNotifikasi = $notifikasiService->jumlah();

        return view('notifikasi.index', compact('notifikasi', 'jumlahNotifikasi'));
    }
}