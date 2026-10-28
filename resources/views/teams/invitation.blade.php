@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-xl space-y-6">
    <a href="{{ route('teams.index') }}" class="inline-flex min-h-10 items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm transition hover:border-blue-200 hover:bg-blue-50 hover:text-[#064B87] focus:outline-none focus:ring-4 focus:ring-blue-100">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7 7-7-7 7-7"/>
        </svg>
        Kembali
    </a>

    <section class="rounded-2xl border border-gray-200 bg-white p-6 text-center shadow-sm sm:p-8">
        <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-[#064B87]" aria-hidden="true">
            <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a4 4 0 00-5-4M9 20H4v-2a4 4 0 015-4m8-4a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </span>
        <p class="mt-5 text-sm font-semibold text-blue-700">Undangan tim</p>
        <h1 class="mt-2 text-2xl font-bold text-gray-900">Bergabung ke {{ $invitation->team->name }}</h1>
        <p class="mx-auto mt-3 max-w-md text-sm leading-6 text-gray-500">
            {{ $invitation->inviter?->nama ?? 'Pemilik tim' }} mengundang akun {{ $invitation->email }} untuk bergabung.
            @if ($invitation->team->description)
                {{ $invitation->team->description }}
            @endif
        </p>
        <form action="{{ route('teams.invitations.accept', ['token' => request()->route('token')]) }}" method="POST" class="mt-7">
            @csrf
            <button type="submit" class="inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl bg-[#064B87] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-100 sm:w-auto">
                Bergabung ke tim
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/>
                </svg>
            </button>
        </form>
        <p class="mt-4 text-xs text-gray-400">Tautan ini hanya dapat digunakan oleh akun email yang diundang.</p>
    </section>
</div>
@endsection