@extends('layouts.app')

@section('content')
<div class="mx-auto flex min-h-[calc(100vh-7rem)] max-w-5xl flex-col gap-5">
    <div>
        <a href="{{ route('teams.show', $team->id) }}" class="inline-flex min-h-10 items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-[#064B87] focus:outline-none focus:ring-4 focus:ring-blue-100">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7 7-7-7 7-7"/>
            </svg>
            Kembali ke tim
        </a>
        <div class="mt-4 flex items-center gap-3">
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#064B87] text-white" aria-hidden="true">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 8h10M7 12h6m-8 8 3.2-3.2A9 9 0 1112 21H5z"/>
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-xs font-semibold uppercase tracking-wide text-blue-700">Chat tim</p>
                <h1 class="truncate text-xl font-bold text-gray-900">{{ $team->name }}</h1>
            </div>
        </div>
    </div>

    <section id="chat" class="flex min-h-[28rem] flex-1 flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 sm:px-6">
            <div>
                <h2 class="font-bold text-gray-900">Percakapan</h2>
                <p class="mt-1 text-xs text-gray-500">Pesan hanya terlihat oleh anggota tim.</p>
            </div>
            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">{{ $messages->count() }} pesan terbaru</span>
        </div>

        <div class="flex-1 space-y-4 overflow-y-auto bg-[#F8FAFC] px-4 py-5 sm:px-6">
            @forelse ($messages as $message)
                @php($pesanSaya = (int) $message->user_id === (int) auth()->id())
                <div class="flex {{ $pesanSaya ? 'justify-end' : 'justify-start' }}">
                    <article class="max-w-[85%] sm:max-w-[72%]">
                        <div class="mb-1 flex items-center gap-2 {{ $pesanSaya ? 'justify-end' : '' }}">
                            <span class="text-xs font-semibold text-gray-700">{{ $pesanSaya ? 'Kamu' : ($message->user?->nama ?? 'Pengguna') }}</span>
                            <time datetime="{{ $message->created_at->toIso8601String() }}" class="text-[11px] text-gray-400">{{ $message->created_at->format('d M, H:i') }}</time>
                        </div>
                        <p class="whitespace-pre-wrap break-words rounded-2xl px-4 py-3 text-sm leading-5 {{ $pesanSaya ? 'rounded-br-md bg-[#064B87] text-white' : 'rounded-bl-md border border-gray-200 bg-white text-gray-800' }}">{{ $message->message }}</p>
                    </article>
                </div>
            @empty
                <div class="flex h-full min-h-64 flex-col items-center justify-center px-6 text-center">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-700" aria-hidden="true">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 8h10M7 12h6m-8 8 3.2-3.2A9 9 0 1112 21H5z"/>
                        </svg>
                    </span>
                    <p class="mt-3 font-semibold text-gray-800">Belum ada pesan</p>
                    <p class="mt-1 text-sm text-gray-500">Mulai percakapan dengan anggota tim.</p>
                </div>
            @endforelse
        </div>

        <form action="{{ route('teams.chat.store', $team->id) }}" method="POST" class="border-t border-gray-100 bg-white p-4 sm:px-6">
            @csrf
            <label for="message" class="sr-only">Tulis pesan</label>
            <div class="flex items-end gap-3">
                <textarea id="message" name="message" rows="2" maxlength="5000" required placeholder="Tulis pesan untuk tim..." class="min-h-12 flex-1 resize-y rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition placeholder:text-gray-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-100">{{ old('message') }}</textarea>
                <button type="submit" class="inline-flex h-12 shrink-0 items-center justify-center gap-2 rounded-xl bg-[#064B87] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-100" aria-label="Kirim pesan">
                    <span class="hidden sm:inline">Kirim</span>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m22 2-7 20-4-9-9-4 20-7ZM22 2 11 13"/>
                    </svg>
                </button>
            </div>
            @error('message')
                <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </form>
    </section>
</div>
@endsection