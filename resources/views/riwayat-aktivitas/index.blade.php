@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <p class="text-sm font-semibold text-blue-700">Catatan perubahan</p>
        <h1 class="mt-1 text-2xl font-bold text-gray-800">Riwayat Aktivitas</h1>
        <p class="mt-1 text-sm text-gray-500">Aktivitas terbaru pada tugas, tim, dan akun.</p>
    </div>

    <section aria-label="Daftar aktivitas" class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <ul class="divide-y divide-gray-100">
            @forelse ($aktivitas as $item)
                <li class="flex items-start gap-4 px-5 py-4 sm:px-6">
                    <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-700" aria-hidden="true">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-gray-800">{{ $item->aktivitas }}</p>
                        <p class="mt-1 text-xs text-gray-500">{{ $item->nama ?? 'Pengguna' }} · {{ \Illuminate\Support\Carbon::parse($item->waktu)->format('d M Y, H:i') }}</p>
                    </div>
                </li>
            @empty
                <li class="px-5 py-10 text-center sm:px-6">
                    <p class="font-semibold text-gray-700">Belum ada aktivitas</p>
                    <p class="mt-1 text-sm text-gray-500">Aktivitas baru akan tercatat saat kamu mengelola tugas, tim, atau akun.</p>
                </li>
            @endforelse
        </ul>

        @if ($aktivitas->hasPages())
            <div class="border-t border-gray-100 px-5 py-4 sm:px-6">{{ $aktivitas->links() }}</div>
        @endif
    </section>
</div>
@endsection