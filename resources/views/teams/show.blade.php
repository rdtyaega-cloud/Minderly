@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <a href="{{ route('teams.index') }}" class="inline-flex min-h-10 w-fit items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-[#064B87] focus:outline-none focus:ring-4 focus:ring-blue-100">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7 7-7-7 7-7"/>
            </svg>
            Kembali ke Kolaborasi Tim
        </a>
        <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold text-blue-700">Detail tim</p>
                <h1 class="mt-1 text-2xl font-bold text-gray-800">{{ $team->name }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ $team->description ?: 'Belum ada deskripsi tim.' }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <span class="w-fit rounded-full bg-blue-50 px-3 py-1.5 text-sm font-semibold text-blue-700">{{ $team->members->count() }} anggota</span>
                <a href="{{ route('teams.chat.index', $team->id) }}" class="inline-flex min-h-10 items-center gap-2 rounded-xl bg-[#064B87] px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-100">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 8h10M7 12h6m-8 8 3.2-3.2A9 9 0 1112 21H5z"/>
                    </svg>
                    Chat tim
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div role="alert" class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($bolehKelolaAnggota)
        <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="font-bold text-gray-900">Undang lewat email</h2>
            <p class="mt-1 text-sm text-gray-500">Kami akan mengirim tautan aman yang berlaku selama 7 hari.</p>
            <form action="{{ route('teams.invitations.store', $team->id) }}" method="POST" class="mt-4 flex flex-col gap-3 sm:flex-row">
                @csrf
                <label for="invitation_email" class="sr-only">Email undangan</label>
                <input id="invitation_email" name="email" type="email" value="{{ old('email') }}" required placeholder="nama@email.com" class="min-w-0 flex-1 rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                <button type="submit" class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-[#064B87] px-5 py-3 text-sm font-semibold text-white shadow-sm shadow-blue-900/10 transition hover:-translate-y-0.5 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-100">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7l9 6 9-6M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/>
                    </svg>
                    Kirim undangan
                </button>
            </form>
            @if ($undanganTertunda->isNotEmpty())
                <div class="mt-5 border-t border-gray-100 pt-4">
                    <h3 class="text-xs font-semibold uppercase tracking-wide text-gray-500">Undangan tertunda</h3>
                    <ul class="mt-2 space-y-2">
                        @foreach ($undanganTertunda as $undangan)
                            <li class="flex items-center justify-between gap-3 text-sm">
                                <span class="min-w-0 truncate text-gray-700">{{ $undangan->email }}</span>
                                <span class="shrink-0 text-xs text-gray-400">Berlaku s.d. {{ $undangan->expires_at->format('d M Y') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </section>
    @endif

    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-100 px-5 py-4 sm:px-6">
            <h2 class="font-bold text-gray-900">Anggota tim</h2>
            <p class="mt-1 text-sm text-gray-500">Orang yang memiliki akses ke tim ini.</p>
        </div>
        <ul class="divide-y divide-gray-100">
            @forelse ($team->members as $anggota)
                <li class="flex items-center justify-between gap-4 px-5 py-4 sm:px-6">
                    <div class="flex min-w-0 items-center gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-[#064B87]">{{ strtoupper(substr($anggota->user?->nama ?? 'P', 0, 1)) }}</span>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-gray-800">{{ $anggota->user?->nama ?? 'Pengguna' }}</p>
                            <p class="truncate text-xs text-gray-500">{{ $anggota->user?->email }}</p>
                        </div>
                    </div>
                    <div class="flex shrink-0 items-center gap-3">
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $anggota->role === 'owner' ? 'bg-amber-50 text-amber-700' : 'bg-gray-100 text-gray-600' }}">{{ $anggota->role === 'owner' ? 'Pemilik' : 'Anggota' }}</span>
                        @if ($bolehKelolaAnggota && $anggota->role !== 'owner')
                            <form action="{{ route('teams.members.destroy', [$team->id, $anggota->user_id]) }}" method="POST" onsubmit="return confirm('Hapus anggota ini dari tim?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex min-h-9 items-center gap-1.5 rounded-lg border border-rose-200 bg-white px-3 py-2 text-xs font-semibold text-rose-700 transition hover:border-rose-300 hover:bg-rose-50 focus:outline-none focus:ring-2 focus:ring-rose-100" aria-label="Hapus {{ $anggota->user?->nama }} dari tim" title="Hapus anggota">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16m-10 4v6m4-6v6M6 7l1 14h10l1-14M9 7V4h6v3"/>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </li>
            @empty
                <li class="px-5 py-10 text-center text-sm text-gray-500 sm:px-6">Belum ada anggota di tim ini.</li>
            @endforelse
        </ul>
    </section>
</div>
@endsection