
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minderly</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#EFF7FF] text-gray-800 font-sans antialiased">
<div class="flex min-h-screen">
    @include('layouts.partials.sidebar')

    <!-- CONTENT -->
    <div class="flex-1 min-w-0">
        <!-- HEADER -->
        <header class="h-[68px] bg-white border-b border-gray-200 flex items-center justify-between px-6 sticky top-0 z-10">
            <div class="flex items-center gap-4">
                <button type="button" class="text-gray-500 hover:text-[#064B87] transition" aria-label="Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <h1 class="font-bold text-lg text-gray-800">Dashboard</h1>
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
                    AP
                </div>
            </div>
        </header>

        <!-- MAIN -->
        <main class="p-5 md:p-7 overflow-x-hidden">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
