<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Services\NotifikasiService;

class DashboardController extends Controller
{
    public function index(NotifikasiService $notifikasiService)
    {
        $hariIni = today();
        $idPengguna = auth()->id();

        $totalTugas = Tugas::where('id_pengguna', $idPengguna)->count();
        $dalamProses = Tugas::where('id_pengguna', $idPengguna)->where('status', 'Sedang Dikerjakan')->count();
        $selesai = Tugas::where('id_pengguna', $idPengguna)->where('status', 'Selesai')->count();
        $belumMulai = Tugas::where('id_pengguna', $idPengguna)->where('status', 'Belum Mulai')->count();
        $lewatTenggat = Tugas::where('id_pengguna', $idPengguna)
            ->where('status', '!=', 'Selesai')
            ->whereNotNull('deadline')
            ->whereDate('deadline', '<', $hariIni)
            ->count();

        $jumlahPrioritasTinggi = Tugas::where('id_pengguna', $idPengguna)->whereNotNull('skor_prioritas')
            ->where('skor_prioritas', '>=', 80)
            ->count();
        $jumlahPrioritasSedang = Tugas::where('id_pengguna', $idPengguna)->where('skor_prioritas', '>=', 50)
            ->where('skor_prioritas', '<', 80)
            ->count();
        $jumlahPrioritasRendah = Tugas::where('id_pengguna', $idPengguna)->whereNotNull('skor_prioritas')
            ->where('skor_prioritas', '<', 50)
            ->count();
        $jumlahPrioritasBelumDihitung = Tugas::where('id_pengguna', $idPengguna)->whereNull('skor_prioritas')->count();

        $diagramStatus = [
            'labels' => ['Belum Mulai', 'Sedang Dikerjakan', 'Selesai'],
            'data' => [$belumMulai, $dalamProses, $selesai],
        ];
        $diagramPrioritas = [
            'labels' => ['Tinggi', 'Sedang', 'Rendah', 'Belum dihitung'],
            'data' => [
                $jumlahPrioritasTinggi,
                $jumlahPrioritasSedang,
                $jumlahPrioritasRendah,
                $jumlahPrioritasBelumDihitung,
            ],
        ];

        $reminders = Tugas::where('id_pengguna', $idPengguna)
            ->where('status', '!=', 'Selesai')
            ->whereNotNull('deadline')
            ->whereDate('deadline', '>=', $hariIni)
            ->whereDate('deadline', '<=', $hariIni->copy()->addDays(7))
            ->orderBy('deadline')
            ->orderByDesc('skor_prioritas')
            ->limit(5)
            ->get();

        $jumlahNotifikasi = $notifikasiService->jumlah();
        $notifikasi = $notifikasiService->terbaru();

        $tugasAktif = Tugas::where('id_pengguna', $idPengguna)->whereIn('status', [
            'Belum Mulai',
            'Sedang Dikerjakan',
        ])
            ->orderByDesc('skor_prioritas')
            ->orderBy('deadline')
            ->limit(8)
            ->get();

        return view('dashboard.index', compact(
            'totalTugas',
            'belumMulai',
            'dalamProses',
            'selesai',
            'lewatTenggat',
            'diagramStatus',
            'diagramPrioritas',
            'reminders',
            'notifikasi',
            'jumlahNotifikasi',
            'tugasAktif'
        ));
    }
}
