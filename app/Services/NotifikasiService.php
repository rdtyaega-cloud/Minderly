<?php

namespace App\Services;

use App\Models\Tugas;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class NotifikasiService
{
    public function jumlah(): int
    {
        return $this->query()->count();
    }

    public function terbaru(int $limit = 5): Collection
    {
        return $this->query()->limit($limit)->get();
    }

    public function semua(): Collection
    {
        return $this->query()->get();
    }

    private function query(): Builder
    {
        $hariIni = today();
        $batasNotifikasi = $hariIni->copy()->addDays(3);

        return Tugas::query()
            ->where('id_pengguna', auth()->id())
            ->whereIn('status', ['Belum Mulai', 'Sedang Dikerjakan'])
            ->where(function ($query) use ($hariIni, $batasNotifikasi) {
                $query->where(function ($deadlineQuery) use ($batasNotifikasi) {
                    $deadlineQuery->whereNotNull('deadline')
                        ->whereDate('deadline', '<=', $batasNotifikasi);
                })->orWhere('skor_prioritas', '>=', 80);
            })
            ->orderByRaw(
                'CASE
                    WHEN deadline IS NOT NULL AND deadline < ? THEN 3
                    WHEN deadline = ? THEN 2
                    WHEN deadline IS NOT NULL AND deadline <= ? THEN 1
                    ELSE 0
                END DESC',
                [
                    $hariIni->toDateString(),
                    $hariIni->toDateString(),
                    $batasNotifikasi->toDateString(),
                ]
            )
            ->orderByDesc('skor_prioritas')
            ->orderBy('deadline');
    }
}