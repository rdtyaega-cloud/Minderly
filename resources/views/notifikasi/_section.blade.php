<section id="notifikasi" aria-labelledby="notifikasi-title" class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm">
    <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
        <div class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl {{ $jumlahNotifikasi > 0 ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600' }}">
                <i class="fas {{ $jumlahNotifikasi > 0 ? 'fa-bell' : 'fa-check' }}"></i>
            </span>
            <div>
                <h2 id="notifikasi-title" class="font-bold text-slate-900">{{ $judulBagian }}</h2>
                <p class="mt-1 text-sm text-slate-500">
                    {{ $jumlahNotifikasi > 0 ? $jumlahNotifikasi . ' tugas perlu perhatian' : 'Tidak ada hal yang perlu ditindaklanjuti' }}
                </p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="w-fit rounded-full px-3 py-1 text-xs font-semibold {{ $jumlahNotifikasi > 0 ? 'bg-rose-50 text-rose-700' : 'bg-emerald-50 text-emerald-700' }}">
                {{ $jumlahNotifikasi > 0 ? 'Perlu ditinjau' : 'Semua aman' }}
            </span>
            @if (!request()->routeIs('notifications.index'))
                <a href="{{ route('notifications.index') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-900">Lihat semua</a>
            @endif
        </div>
    </div>

    <ul class="divide-y divide-slate-100 px-5 sm:px-6">
        @forelse ($notifikasi as $tugas)
            @php
                $tglDeadline = $tugas->deadline ? \Carbon\Carbon::parse($tugas->deadline) : null;
                $terlambat = $tglDeadline && $tglDeadline->lt(today());
                $hariIniDeadline = $tglDeadline && $tglDeadline->isToday();
                $skorPrioritas = $tugas->skor_prioritas;
                $labelNotifikasi = $terlambat
                    ? 'Tenggat terlewat'
                    : ($hariIniDeadline
                        ? 'Jatuh tempo hari ini'
                        : ($tglDeadline && $tglDeadline->lte(today()->addDays(3))
                            ? 'Segera jatuh tempo'
                            : 'Prioritas tinggi'));
                $warnaNotifikasi = $terlambat || $hariIniDeadline
                    ? 'bg-rose-50 text-rose-700'
                    : ($labelNotifikasi === 'Prioritas tinggi'
                        ? 'bg-violet-50 text-violet-700'
                        : 'bg-orange-50 text-orange-700');
            @endphp
            <li class="flex flex-col gap-3 py-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex min-w-0 items-start gap-3">
                    <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $terlambat || $hariIniDeadline ? 'bg-rose-50 text-rose-600' : ($labelNotifikasi === 'Prioritas tinggi' ? 'bg-violet-50 text-violet-600' : 'bg-orange-50 text-orange-600') }}">
                        <i class="fas {{ $terlambat ? 'fa-triangle-exclamation' : ($labelNotifikasi === 'Prioritas tinggi' ? 'fa-bolt' : 'fa-clock') }} text-sm"></i>
                    </span>
                    <div class="min-w-0">
                        <a href="{{ url('/tugas/edit/' . $tugas->id_tugas) }}" class="block truncate text-sm font-semibold text-slate-800 hover:text-blue-700">
                            {{ $tugas->judul }}
                        </a>
                        <p class="mt-1 text-xs text-slate-500">
                            @if ($tglDeadline)
                                Tenggat {{ $tglDeadline->format('d M Y') }}
                            @else
                                Periksa tugas dengan skor prioritas tinggi
                            @endif
                            @if ($skorPrioritas !== null)
                                <span class="mx-1 text-slate-300">·</span>
                                Skor {{ round($skorPrioritas) }}%
                            @endif
                        </p>
                    </div>
                </div>
                <span class="w-fit shrink-0 rounded-full px-3 py-1 text-xs font-semibold {{ $warnaNotifikasi }}">
                    {{ $labelNotifikasi }}
                </span>
            </li>
        @empty
            <li class="py-5 text-sm text-slate-500">
                Notifikasi akan muncul untuk tugas terlambat, mendekati tenggat, atau memiliki prioritas tinggi.
            </li>
        @endforelse
    </ul>
</section>