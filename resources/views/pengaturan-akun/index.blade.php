@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <div>
        <p class="text-sm font-semibold text-blue-700">Preferensi pengguna</p>
        <h1 class="mt-1 text-2xl font-bold text-gray-800">Pengaturan Akun</h1>
        <p class="mt-1 text-sm text-gray-500">Perbarui nama dan email akun Minderly.</p>
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

    <form action="{{ route('account.update') }}" method="POST" class="space-y-5 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-7">
        @csrf
        @method('PUT')

        <div>
            <label for="nama" class="mb-2 block text-sm font-semibold text-gray-700">Nama</label>
            <input id="nama" name="nama" type="text" value="{{ old('nama', $pengguna->nama) }}" required maxlength="100" autocomplete="name" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>

        <div>
            <label for="email" class="mb-2 block text-sm font-semibold text-gray-700">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $pengguna->email) }}" required maxlength="100" autocomplete="email" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>

        <div class="border-t border-gray-100 pt-5">
            <h2 class="font-semibold text-gray-800">Ganti password</h2>
            <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengganti password.</p>
        </div>

        <div>
            <label for="current_password" class="mb-2 block text-sm font-semibold text-gray-700">Password saat ini</label>
            <input id="current_password" name="current_password" type="password" autocomplete="current-password" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>

        <div>
            <label for="password" class="mb-2 block text-sm font-semibold text-gray-700">Password baru</label>
            <input id="password" name="password" type="password" autocomplete="new-password" minlength="8" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>

        <div>
            <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-gray-700">Konfirmasi password baru</label>
            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="8" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
        </div>

        <div class="flex justify-end border-t border-gray-100 pt-5">
            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-[#064B87] px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-800">
                Simpan perubahan
            </button>
        </div>
    </form>
</div>
@endsection