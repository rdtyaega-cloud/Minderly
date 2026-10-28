@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold text-blue-700">Perencanaan tugas</p>
            <h1 class="mt-1 text-2xl font-bold text-gray-800">Kalender &amp; Jadwal</h1>
            <p class="mt-1 text-sm text-gray-500">Pantau tenggat tugas dalam tampilan bulanan.</p>
        </div>
        <a href="{{ url('/tugas/tambah') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#064B87] px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-800">
            <span aria-hidden="true">+</span>
            Tambah tugas
        </a>
    </div>

    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm" aria-label="Kalender tugas">
        <div class="flex flex-col gap-4 border-b border-gray-100 p-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('calendar.index', ['bulan' => $bulanSebelumnya]) }}" aria-label="Bulan sebelumnya" class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 text-gray-600 transition hover:bg-blue-50 hover:text-blue-700">
                    <span aria-hidden="true">&larr;</span>
                </a>
                <h2 class="min-w-44 text-center text-lg font-bold text-gray-800">{{ $bulan->locale('id')->translatedFormat('F Y') }}</h2>
                <a href="{{ route('calendar.index', ['bulan' => $bulanBerikutnya]) }}" aria-label="Bulan berikutnya" class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-200 text-gray-600 transition hover:bg-blue-50 hover:text-blue-700">
                    <span aria-hidden="true">&rarr;</span>
                </a>
                <a href="{{ route('calendar.index') }}" class="ml-1 text-sm font-semibold text-blue-700 hover:text-blue-900">Hari ini</a>
            </div>
            <p class="text-sm text-gray-500"><span class="font-semibold text-gray-800">{{ $totalTugas }}</span> tugas bertenggat bulan ini</p>
        </div>

        <div class="grid grid-cols-7 border-l border-t border-gray-100">
            @foreach (['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $namaHari)
                <div class="border-b border-r border-gray-100 bg-gray-50 px-1 py-3 text-center text-xs font-semibold text-gray-500 sm:text-sm">{{ $namaHari }}</div>
            @endforeach

            @foreach ($hari as $tanggal)
                @php
                    $tanggalIni = $tanggal->toDateString();
                    $daftarTugas = $tugasPerTanggal->get($tanggalIni, collect());
                    $bulanLain = !$tanggal->isSameMonth($bulan);
                @endphp
                <div class="min-h-24 border-b border-r border-gray-100 p-1.5 sm:min-h-32 sm:p-2 {{ $bulanLain ? 'bg-gray-50/70' : 'bg-white' }}">
                    <div class="mb-1 flex justify-end">
                        <time datetime="{{ $tanggalIni }}" class="flex h-7 w-7 items-center justify-center rounded-full text-xs font-medium {{ $tanggal->isToday() ? 'bg-[#064B87] font-bold text-white' : ($bulanLain ? 'text-gray-300' : 'text-gray-700') }}">{{ $tanggal->day }}</time>
                    </div>
                    <div class="space-y-1">
                        @foreach ($daftarTugas->take(3) as $tugas)
                            <a href="{{ url('/tugas/edit/' . $tugas->id_tugas) }}" title="{{ $tugas->judul }}" class="block truncate rounded-md px-1.5 py-1 text-[10px] font-medium leading-4 sm:px-2 sm:text-xs {{ $tugas->status === 'Selesai' ? 'bg-emerald-50 text-emerald-700' : ($tanggal->isPast() && !$tanggal->isToday() ? 'bg-rose-50 text-rose-700' : 'bg-blue-50 text-blue-800') }}">
                                {{ $tugas->judul }}
                            </a>
                        @endforeach
                        @if ($daftarTugas->count() > 3)
                            <p class="px-1 text-[10px] font-semibold text-gray-500 sm:px-2 sm:text-xs">+{{ $daftarTugas->count() - 3 }} tugas</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection