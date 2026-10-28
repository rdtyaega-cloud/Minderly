@php
    $namaPengguna = auth()->user()?->nama ?? auth()->user()?->name ?? 'Pengguna';
    $inisialPengguna = strtoupper(substr($namaPengguna, 0, 2));
    $jumlahNotifikasiSidebar = $jumlahNotifikasi ?? 0;
@endphp

<aside id="appSidebar" aria-label="Navigasi utama" class="hidden sticky top-0 h-screen w-64 shrink-0 overflow-y-auto bg-[#064B87] px-5 py-6 text-white flex-col lg:flex">
    <a href="{{ url('/dashboard') }}" class="mb-9 px-2">
        <h1 class="text-xl font-bold tracking-wide text-white">✓ MINDERLY</h1>
        <p class="text-xs text-blue-200 mt-1">Task Management System</p>
    </a>

    <div class="mb-8 rounded-xl bg-white/10 border border-white/10 p-3">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-blue-200 text-[#064B87] flex items-center justify-center font-bold">
                {{ $inisialPengguna }}
            </div>
            <div class="min-w-0">
                <h2 class="font-semibold text-sm text-white truncate">{{ $namaPengguna }}</h2>
                <p class="text-xs text-blue-200 mt-1">Task Management System</p>
            </div>
        </div>
    </div>

    <nav class="space-y-1" aria-label="Navigasi utama">
        <a href="{{ url('/dashboard') }}" @if(request()->is('dashboard')) aria-current="page" @endif class="flex items-center gap-3 px-3 py-3 rounded-xl transition {{ request()->is('dashboard') ? 'bg-white text-[#064B87] font-semibold shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9v9a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            </svg>
            <span class="text-sm">Dashboard</span>
        </a>

        <a href="{{ url('/tugas') }}" @if(request()->is('tugas*')) aria-current="page" @endif class="flex items-center gap-3 px-3 py-3 rounded-xl transition {{ request()->is('tugas*') ? 'bg-white text-[#064B87] font-semibold shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M9 5h6M9 9h6M9 13h6M5 5h.01M5 9h.01M5 13h.01"/>
            </svg>
            <span class="text-sm">Manajemen Tugas</span>
        </a>

        <a href="{{ route('teams.index') }}" @if(request()->is('teams*')) aria-current="page" @endif class="flex items-center gap-3 px-3 py-3 rounded-xl transition {{ request()->is('teams*') ? 'bg-white text-[#064B87] font-semibold shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-4M9 20H4v-2a4 4 0 015-4m8-4a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <span class="text-sm">Kolaborasi Tim</span>
        </a>

        <a href="{{ route('calendar.index') }}" @if(request()->is('kalender*')) aria-current="page" @endif class="flex items-center gap-3 px-3 py-3 rounded-xl transition {{ request()->is('kalender*') ? 'bg-white text-[#064B87] font-semibold shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M5 11h14M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <span class="text-sm">Kalender &amp; Jadwal</span>
        </a>

        <a href="{{ route('account.index') }}" @if(request()->is('pengaturan-akun*')) aria-current="page" @endif class="flex items-center gap-3 px-3 py-3 rounded-xl transition {{ request()->is('pengaturan-akun*') ? 'bg-white text-[#064B87] font-semibold shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M12 15.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7z"/>
                <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M19.4 15a1.7 1.7 0 00.34 1.88l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.7 1.7 0 00-1.88-.34 1.7 1.7 0 00-1.03 1.56V21a2 2 0 01-4 0v-.09a1.7 1.7 0 00-1.03-1.56 1.7 1.7 0 00-1.88.34l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.7 1.7 0 004.6 15a1.7 1.7 0 00-1.56-1H3a2 2 0 010-4h.09a1.7 1.7 0 001.56-1 1.7 1.7 0 00-.34-1.88l-.06-.06A2 2 0 017.08 4.23l.06.06a1.7 1.7 0 001.88.34H9a1.7 1.7 0 001-1.56V3a2 2 0 014 0v.09a1.7 1.7 0 001 1.56 1.7 1.7 0 001.88-.34l.06-.06a2 2 0 012.83 2.83l-.06.06a1.7 1.7 0 00-.34 1.88V9c0 .66.39 1.25 1 1.5.18.08.37.1.56.1H21a2 2 0 010 4h-.09c-.66 0-1.25.39-1.51 1z"/>
            </svg>
            <span class="text-sm">Pengaturan Akun</span>
        </a>
    </nav>

    <div class="mt-8">
        <p class="text-xs font-bold text-blue-200 mb-3 px-3 tracking-wider">SISTEM</p>

        <a href="{{ route('notifications.index') }}" @if(request()->is('notifikasi*')) aria-current="page" @endif class="flex items-center gap-3 px-3 py-3 rounded-xl transition {{ request()->is('notifikasi*') ? 'bg-white text-[#064B87] font-semibold shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.5-2V11a6.5 6.5 0 10-13 0v4L4 17h5"/>
            </svg>
            <span class="text-sm">Notifikasi</span>
            @if($jumlahNotifikasiSidebar > 0)
                <span class="ml-auto rounded-full bg-rose-500 px-2 py-0.5 text-xs font-semibold text-white">{{ $jumlahNotifikasiSidebar > 99 ? '99+' : $jumlahNotifikasiSidebar }}</span>
            @endif
        </a>

        <a href="{{ route('activity.index') }}" @if(request()->is('riwayat-aktivitas*')) aria-current="page" @endif class="flex items-center gap-3 px-3 py-3 rounded-xl transition {{ request()->is('riwayat-aktivitas*') ? 'bg-white text-[#064B87] font-semibold shadow-sm' : 'text-blue-100 hover:bg-white/10 hover:text-white' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm">Riwayat Aktivitas</span>
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-3 rounded-xl text-left text-red-200 hover:bg-red-500/20 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
            </svg>
            <span class="text-sm">Log Out</span>
            </button>
        </form>
    </div>

    <div class="mt-auto pt-8 px-3">
        <p class="text-xs text-blue-200">&copy; {{ date('Y') }} Minderly</p>
        <p class="text-xs text-blue-300 mt-1">Task Management System</p>
    </div>
</aside>