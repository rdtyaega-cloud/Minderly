@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-semibold text-blue-700">Pantau tenggat dan prioritas</p>
            <h1 class="mt-1 text-2xl font-bold text-gray-800">Pusat Notifikasi</h1>
            <p class="mt-1 text-sm text-gray-500">Semua tugas yang perlu perhatianmu.</p>
        </div>
        <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-700 hover:text-blue-900">
            Kembali ke dashboard
            <span aria-hidden="true">&rarr;</span>
        </a>
    </div>

    @include('notifikasi._section', ['judulBagian' => 'Daftar notifikasi'])
</div>
@endsection