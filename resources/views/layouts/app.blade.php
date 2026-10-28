
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minderly</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#EFF7FF] text-gray-800 font-sans antialiased">
@php
    $judulHalaman = match (true) {
        request()->routeIs('dashboard') => 'Dashboard',
        request()->routeIs('notifications.index') => 'Notifikasi',
        request()->routeIs('account.*') => 'Pengaturan Akun',
        request()->routeIs('activity.index') => 'Riwayat Aktivitas',
        request()->routeIs('calendar.index') => 'Kalender & Jadwal',
        request()->routeIs('teams.create') => 'Buat Tim Baru',
        request()->routeIs('teams.*') => 'Kolaborasi Tim',
        request()->is('tugas/tambah') => 'Tambah Tugas',
        request()->is('tugas/edit/*') => 'Edit Tugas',
        request()->is('tugas*') => 'Manajemen Tugas',
        default => 'Minderly',
    };
@endphp
<div class="flex min-h-screen">
    @include('layouts.partials.sidebar')
    <div id="sidebarOverlay" class="fixed inset-0 z-[5] hidden bg-slate-950/40 lg:hidden" aria-hidden="true"></div>

    <!-- CONTENT -->
    <div class="flex-1 min-w-0">
        <!-- HEADER -->
        <header class="h-[68px] bg-white border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-50">
            <div class="flex items-center gap-4">
                <button id="sidebarToggle" type="button" class="flex h-10 w-10 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-[#064B87] focus:outline-none focus:ring-2 focus:ring-blue-200" aria-label="Tampilkan sidebar" aria-controls="appSidebar" aria-expanded="false">
                    <svg id="sidebarMenuIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg id="sidebarCloseIcon" class="hidden h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="m6 6 12 12M18 6 6 18"/>
                    </svg>
                </button>
                <h1 class="font-bold text-lg text-gray-800">{{ $judulHalaman }}</h1>
            </div>

            <div class="flex items-center gap-4">
        
<form action="{{ url('/tugas') }}" method="GET"
    class="relative hidden sm:block">

    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Cari Tugas..."
        autocomplete="off"
        class="w-56 lg:w-72 border border-gray-200 bg-gray-50 rounded-xl pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-400"
    >

    <button
        type="submit"
        aria-label="Cari tugas"
        class="absolute left-0 top-0 h-full pl-3 flex items-center text-gray-400 hover:text-blue-600"
    >
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="7" stroke-width="2"/>
            <path stroke-width="2" stroke-linecap="round" d="m16 16 4 4"/>
        </svg>
    </button>
</form>

                <button type="button" class="relative w-9 h-9 rounded-xl hover:bg-gray-100 flex items-center justify-center text-gray-500" aria-label="Notifikasi">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" d="M18 8a6 6 0 00-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/>
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <div class="w-9 h-9 rounded-full bg-blue-100 text-[#064B87] flex items-center justify-center font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->nama ?? auth()->user()->name ?? 'P', 0, 2)) }}
                </div>
            </div>
        </header>

        <!-- MAIN -->
        <main class="p-5 md:p-7 overflow-x-hidden">
            @yield('content')
        </main>
    </div>
</div>
<script>
    const sidebar = document.getElementById('appSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const sidebarMenuIcon = document.getElementById('sidebarMenuIcon');
    const sidebarCloseIcon = document.getElementById('sidebarCloseIcon');
    const mobileSidebar = window.matchMedia('(max-width: 1023px)');

    function setSidebarButtonState(isOpen) {
        sidebarToggle.setAttribute('aria-expanded', String(isOpen));
        sidebarToggle.setAttribute('aria-label', isOpen ? 'Sembunyikan sidebar' : 'Tampilkan sidebar');
        sidebarMenuIcon.classList.toggle('hidden', isOpen);
        sidebarCloseIcon.classList.toggle('hidden', !isOpen);
    }

    function closeMobileSidebar() {
        sidebarOverlay.classList.add('hidden');
        sidebar.style.cssText = '';
        document.body.style.overflow = '';
        setSidebarButtonState(false);
    }

    sidebarToggle.addEventListener('click', () => {
        if (mobileSidebar.matches) {
            const isOpen = !sidebarOverlay.classList.contains('hidden');

            if (isOpen) {
                closeMobileSidebar();
                return;
            }

            sidebar.style.cssText = 'display:flex;position:fixed;inset:0 auto 0 0;z-index:40;width:16rem;height:100dvh;box-shadow:0 12px 32px rgba(15,23,42,.22)';
            sidebarOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            setSidebarButtonState(true);
            return;
        }

        const isOpen = sidebar.style.display === 'none';
        sidebar.style.display = isOpen ? '' : 'none';
        setSidebarButtonState(isOpen);
    });

    sidebarOverlay.addEventListener('click', closeMobileSidebar);
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && mobileSidebar.matches && !sidebarOverlay.classList.contains('hidden')) {
            closeMobileSidebar();
            sidebarToggle.focus();
        }
    });

    window.addEventListener('resize', () => {
        closeMobileSidebar();
        if (!mobileSidebar.matches) {
            setSidebarButtonState(sidebar.style.display !== 'none');
        }
    });

    setSidebarButtonState(!mobileSidebar.matches);
</script>
</body>
</html>
