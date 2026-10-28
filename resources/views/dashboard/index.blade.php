<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Minderly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.8/dist/chart.umd.min.js"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased">
    @php
        $persentaseSelesai = $totalTugas > 0 ? round(($selesai / $totalTugas) * 100) : 0;
    @endphp

    <div class="min-h-screen lg:flex">
        <div class="hidden lg:flex">
            @include('layouts.partials.sidebar')
        </div>

        <main class="min-w-0 flex-1">
            <header class="sticky top-0 z-10 border-b border-slate-200/80 bg-white/95 px-4 py-4 backdrop-blur sm:px-6 lg:px-10">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-blue-700">Minderly</p>
                        <h1 class="mt-1 text-lg font-bold text-slate-900 sm:text-xl">Dashboard</h1>
                    </div>
                    <div class="flex items-center gap-2 sm:gap-4">
                        <a href="{{ route('notifications.index') }}" aria-label="Notifikasi ({{ $jumlahNotifikasi }})" class="relative flex h-10 w-10 items-center justify-center rounded-xl text-slate-600 transition hover:bg-slate-100 hover:text-blue-700">
                            <i class="fas fa-bell"></i>
                            @if($jumlahNotifikasi > 0)
                                <span class="absolute -right-1 -top-1 flex h-5 min-w-5 items-center justify-center rounded-full bg-rose-600 px-1 text-[10px] font-bold text-white">
                                    {{ $jumlahNotifikasi > 99 ? '99+' : $jumlahNotifikasi }}
                                </span>
                            @endif
                        </a>
                        <a href="{{ url('/tugas') }}" class="hidden rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 sm:inline-flex sm:items-center sm:gap-2">
                            <i class="fas fa-list-check"></i>
                            Tugas Saya
                        </a>
                        <a href="{{ url('/tugas/tambah') }}" class="inline-flex items-center gap-2 rounded-xl bg-[#1557A0] px-3 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#10477f] sm:px-4">
                            <i class="fas fa-plus"></i>
                            <span class="hidden sm:inline">Tugas Baru</span>
                            <span class="sm:hidden">Tambah</span>
                        </a>
                        <div class="hidden h-10 w-10 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-800 sm:flex" aria-label="Pengguna">
                            M
                        </div>
                    </div>
                </div>
            </header>

            <div class="mx-auto max-w-7xl space-y-7 px-4 py-6 sm:px-6 sm:py-8 lg:px-10">
                <section class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#123D75] to-[#2474C6] px-6 py-7 text-white shadow-lg shadow-blue-900/10 sm:px-8 sm:py-9">
                    <div class="pointer-events-none absolute -right-10 -top-24 h-64 w-64 rounded-full border-[30px] border-white/5"></div>
                    <div class="pointer-events-none absolute -bottom-24 right-40 h-48 w-48 rounded-full bg-white/5"></div>
                    <div class="relative flex flex-col justify-between gap-6 sm:flex-row sm:items-end">
                        <div>
                            <p class="text-sm font-medium text-blue-100">Ruang kerjamu, lebih tertata.</p>
                            <h2 class="mt-2 text-2xl font-bold tracking-tight sm:text-3xl">Halo, selamat datang</h2>
                            <p class="mt-2 max-w-xl text-sm leading-6 text-blue-100 sm:text-base">Pantau progres dan fokus pada hal yang paling penting hari ini.</p>
                        </div>
                        <a href="{{ url('/tugas') }}" class="inline-flex w-fit items-center gap-2 rounded-xl bg-white px-4 py-3 text-sm font-bold text-[#1557A0] shadow-sm transition hover:bg-blue-50">
                            Lihat semua tugas
                            <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </section>

                <section aria-label="Ringkasan tugas">
                    <div class="mb-4 flex items-end justify-between gap-3">
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">Ringkasan tugas</h2>
                            <p class="mt-1 text-sm text-slate-500">Gambaran progres pekerjaanmu saat ini.</p>
                        </div>
                        <p class="hidden text-sm text-slate-400 sm:block">Data terbaru</p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 sm:gap-4 xl:grid-cols-4">
                        <article class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm sm:p-5">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <p class="text-xs font-medium text-slate-500 sm:text-sm">Total Tugas</p>
                                    <p class="mt-2 text-2xl font-bold text-slate-900 sm:text-3xl">{{ $totalTugas }}</p>
                                </div>
                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-700 sm:h-11 sm:w-11">
                                    <i class="fas fa-layer-group"></i>
                                </span>
                            </div>
                            <p class="mt-3 text-xs text-slate-400">Semua tugas tercatat</p>
                        </article>

                        <article class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm sm:p-5">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <p class="text-xs font-medium text-slate-500 sm:text-sm">Dalam Proses</p>
                                    <p class="mt-2 text-2xl font-bold text-amber-600 sm:text-3xl">{{ $dalamProses }}</p>
                                </div>
                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600 sm:h-11 sm:w-11">
                                    <i class="fas fa-spinner"></i>
                                </span>
                            </div>
                            <p class="mt-3 text-xs text-slate-400">Sedang dikerjakan</p>
                        </article>

                        <article class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm sm:p-5">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <p class="text-xs font-medium text-slate-500 sm:text-sm">Selesai</p>
                                    <p class="mt-2 text-2xl font-bold text-emerald-600 sm:text-3xl">{{ $selesai }}</p>
                                </div>
                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 sm:h-11 sm:w-11">
                                    <i class="fas fa-check"></i>
                                </span>
                            </div>
                            <p class="mt-3 text-xs text-slate-400">{{ $persentaseSelesai }}% dari semua tugas</p>
                        </article>

                        <article class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm sm:p-5">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <p class="text-xs font-medium text-slate-500 sm:text-sm">Lewat Tenggat</p>
                                    <p class="mt-2 text-2xl font-bold text-rose-600 sm:text-3xl">{{ $lewatTenggat }}</p>
                                </div>
                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50 text-rose-600 sm:h-11 sm:w-11">
                                    <i class="fas fa-triangle-exclamation"></i>
                                </span>
                            </div>
                            <p class="mt-3 text-xs text-slate-400">Perlu perhatianmu</p>
                        </article>
                    </div>
                </section>

                <section aria-label="Diagram tugas" class="grid grid-cols-1 gap-5 lg:grid-cols-2">
                    <article class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm sm:p-6">
                        <div class="mb-5">
                            <h2 class="font-bold text-slate-900">Status tugas</h2>
                            <p class="mt-1 text-sm text-slate-500">Perbandingan progres seluruh tugas.</p>
                        </div>
                        <div class="relative mx-auto h-64 max-w-sm">
                            <canvas id="statusChart" role="img" aria-label="Diagram status tugas"></canvas>
                        </div>
                    </article>

                    <article class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm sm:p-6">
                        <div class="mb-5">
                            <h2 class="font-bold text-slate-900">Distribusi prioritas</h2>
                            <p class="mt-1 text-sm text-slate-500">Jumlah tugas berdasarkan skor prioritas.</p>
                        </div>
                        <div class="relative h-64">
                            <canvas id="priorityChart" role="img" aria-label="Diagram distribusi skor prioritas"></canvas>
                        </div>
                    </article>
                </section>

                @include('notifikasi._section', ['judulBagian' => 'Notifikasi'])

                <section class="grid grid-cols-1 gap-5 xl:grid-cols-5">
                    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm xl:col-span-3">
                        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-5 sm:px-6">
                            <div>
                                <h2 class="font-bold text-slate-900">Tugas aktif</h2>
                                <p class="mt-1 text-sm text-slate-500">Prioritas yang perlu kamu selesaikan.</p>
                            </div>
                            <a href="{{ url('/tugas') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-900">
                                Lihat semua <i class="fas fa-arrow-right ml-1 text-xs"></i>
                            </a>
                        </div>

                        <ul class="divide-y divide-slate-100 px-5 sm:px-6">
                            @forelse($tugasAktif as $tugas)
                                <li class="flex flex-col gap-3 py-4 sm:flex-row sm:items-center sm:justify-between">
                                    <div class="flex min-w-0 items-start gap-3">
                                        <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $tugas->status === 'Sedang Dikerjakan' ? 'bg-amber-50 text-amber-600' : 'bg-slate-100 text-slate-500' }}">
                                            <i class="fas {{ $tugas->status === 'Sedang Dikerjakan' ? 'fa-rotate' : 'fa-clipboard-list' }} text-sm"></i>
                                        </span>
                                        <div class="min-w-0">
                                            <a href="{{ url('/tugas/edit/' . $tugas->id_tugas) }}" class="block truncate font-semibold text-slate-800 transition hover:text-blue-700">
                                                {{ $tugas->judul }}
                                            </a>
                                            <p class="mt-1 text-xs text-slate-500">
                                                @if($tugas->deadline)
                                                    Tenggat {{ \Carbon\Carbon::parse($tugas->deadline)->format('d M Y') }}
                                                @else
                                                    Tenggat belum ditentukan
                                                @endif
                                            </p>
                                            @php
                                                $skorPrioritas = $tugas->skor_prioritas;
                                                $labelPrioritas = $skorPrioritas === null
                                                    ? 'Belum dihitung'
                                                    : ($skorPrioritas >= 80 ? 'Tinggi' : ($skorPrioritas >= 50 ? 'Sedang' : 'Rendah'));
                                                $warnaPrioritas = $skorPrioritas === null
                                                    ? 'bg-slate-100 text-slate-600'
                                                    : ($skorPrioritas >= 80 ? 'bg-rose-50 text-rose-700' : ($skorPrioritas >= 50 ? 'bg-amber-50 text-amber-700' : 'bg-emerald-50 text-emerald-700'));
                                            @endphp
                                            <span class="mt-2 inline-flex w-fit items-center gap-1 rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $warnaPrioritas }}">
                                                <i class="fas fa-bolt text-[10px]"></i>
                                                Prioritas {{ $labelPrioritas }}@if($skorPrioritas !== null) · {{ round($skorPrioritas) }}%@endif
                                            </span>
                                        </div>
                                    </div>
                                    <span class="w-fit shrink-0 rounded-full px-3 py-1 text-xs font-semibold {{ $tugas->status === 'Sedang Dikerjakan' ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $tugas->status }}
                                    </span>
                                </li>
                            @empty
                                <li class="py-10 text-center">
                                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                                        <i class="fas fa-clipboard-check"></i>
                                    </span>
                                    <p class="mt-3 font-semibold text-slate-700">Belum ada tugas aktif</p>
                                    <p class="mt-1 text-sm text-slate-500">Tambahkan tugas baru untuk mulai mengatur pekerjaanmu.</p>
                                    <a href="{{ url('/tugas/tambah') }}" class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-900">
                                        <i class="fas fa-plus"></i>
                                        Buat tugas pertama
                                    </a>
                                </li>
                            @endforelse
                        </ul>
                    </div>

                    <aside class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white shadow-sm xl:col-span-2">
                        <div class="border-b border-slate-100 px-5 py-5 sm:px-6">
                            <div class="flex items-center gap-3">
                                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50 text-orange-600">
                                    <i class="fas fa-bell"></i>
                                </span>
                                <div>
                                    <h2 class="font-bold text-slate-900">Deadline mendatang</h2>
                                    <p class="mt-1 text-sm text-slate-500">Dalam 7 hari ke depan</p>
                                </div>
                            </div>
                        </div>

                        <ul class="divide-y divide-slate-100 px-5 sm:px-6">
                            @forelse($reminders as $tugas)
                                @php
                                    $tglDeadline = \Carbon\Carbon::parse($tugas->deadline);
                                    $selisihHari = (int) now()->startOfDay()->diffInDays($tglDeadline->copy()->startOfDay(), false);
                                    $labelDeadline = $selisihHari === 0 ? 'Hari ini' : ($selisihHari === 1 ? 'Besok' : $selisihHari . ' hari lagi');
                                    $skorPrioritas = $tugas->skor_prioritas;
                                    $labelPrioritas = $skorPrioritas === null
                                        ? 'Belum dihitung'
                                        : ($skorPrioritas >= 80 ? 'Tinggi' : ($skorPrioritas >= 50 ? 'Sedang' : 'Rendah'));
                                    $warnaPrioritas = $skorPrioritas === null
                                        ? 'bg-slate-100 text-slate-600'
                                        : ($skorPrioritas >= 80 ? 'bg-rose-50 text-rose-700' : ($skorPrioritas >= 50 ? 'bg-amber-50 text-amber-700' : 'bg-emerald-50 text-emerald-700'));
                                @endphp
                                <li class="flex items-center justify-between gap-3 py-4">
                                    <div class="min-w-0">
                                        <a href="{{ url('/tugas/edit/' . $tugas->id_tugas) }}" class="block truncate text-sm font-semibold text-slate-800 hover:text-blue-700">
                                            {{ $tugas->judul }}
                                        </a>
                                        <p class="mt-1 text-xs text-slate-500">{{ $tglDeadline->format('d M Y') }}</p>
                                        <span class="mt-2 inline-flex rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $warnaPrioritas }}">
                                            Prioritas {{ $labelPrioritas }}@if($skorPrioritas !== null) · {{ round($skorPrioritas) }}%@endif
                                        </span>
                                    </div>
                                    <span class="shrink-0 rounded-lg px-2.5 py-1.5 text-xs font-semibold {{ $selisihHari === 0 ? 'bg-rose-50 text-rose-700' : 'bg-orange-50 text-orange-700' }}">
                                        {{ $labelDeadline }}
                                    </span>
                                </li>
                            @empty
                                <li class="py-10 text-center">
                                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                                        <i class="fas fa-calendar-check"></i>
                                    </span>
                                    <p class="mt-3 font-semibold text-slate-700">Tidak ada deadline dekat</p>
                                    <p class="mt-1 text-sm text-slate-500">Belum ada tugas yang mendekati tenggat dalam 7 hari ke depan.</p>
                                </li>
                            @endforelse
                        </ul>
                    </aside>
                </section>
            </div>
        </main>
    </div>
    <script>
        const statusData = @json($diagramStatus);
        const priorityData = @json($diagramPrioritas);
        const chartFont = { family: 'ui-sans-serif, system-ui, sans-serif' };

        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: statusData.labels,
                datasets: [{
                    data: statusData.data,
                    backgroundColor: ['#94a3b8', '#f59e0b', '#10b981'],
                    borderColor: '#ffffff',
                    borderWidth: 4,
                    hoverOffset: 6,
                }],
            },
            options: {
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, pointStyle: 'circle', padding: 18, font: chartFont },
                    },
                },
            },
        });

        new Chart(document.getElementById('priorityChart'), {
            type: 'bar',
            data: {
                labels: priorityData.labels,
                datasets: [{
                    label: 'Jumlah tugas',
                    data: priorityData.data,
                    backgroundColor: ['#f43f5e', '#f59e0b', '#10b981', '#cbd5e1'],
                    borderRadius: 8,
                    maxBarThickness: 48,
                }],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: chartFont },
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0, stepSize: 1, font: chartFont },
                        grid: { color: '#f1f5f9' },
                    },
                },
            },
        });
    </script>
</body>
</html>
