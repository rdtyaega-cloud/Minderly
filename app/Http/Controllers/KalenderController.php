<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KalenderController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'bulan' => ['nullable', 'date_format:Y-m'],
        ]);

        $bulan = Carbon::createFromFormat(
            '!Y-m',
            $validated['bulan'] ?? today()->format('Y-m')
        )->startOfMonth();

        $awalGrid = $bulan->copy()->startOfWeek(Carbon::MONDAY);
        $akhirGrid = $bulan->copy()->endOfWeek(Carbon::SUNDAY);
        $hari = collect();

        for ($tanggal = $awalGrid->copy(); $tanggal->lte($akhirGrid); $tanggal->addDay()) {
            $hari->push($tanggal->copy());
        }

        $tugasPerTanggal = Tugas::query()
            ->where('id_pengguna', auth()->id())
            ->whereBetween('deadline', [
                $bulan->toDateString(),
                $bulan->copy()->endOfMonth()->toDateString(),
            ])
            ->orderBy('deadline')
            ->orderBy('judul')
            ->get(['id_tugas', 'judul', 'status', 'deadline'])
            ->groupBy('deadline');

        return view('kalender.index', [
            'bulan' => $bulan,
            'hari' => $hari,
            'tugasPerTanggal' => $tugasPerTanggal,
            'totalTugas' => $tugasPerTanggal->flatten(1)->count(),
            'bulanSebelumnya' => $bulan->copy()->subMonth()->format('Y-m'),
            'bulanBerikutnya' => $bulan->copy()->addMonth()->format('Y-m'),
        ]);
    }
}