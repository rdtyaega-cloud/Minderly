<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Minderly</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-[#EFF7FF] text-gray-800 antialiased">
    <main class="grid min-h-screen lg:grid-cols-[0.85fr_1.15fr]">
        <section class="flex min-h-48 flex-col justify-between bg-[#064B87] px-7 py-8 text-white sm:px-12 sm:py-12 lg:min-h-screen lg:px-16 lg:py-14">
            <a href="{{ url('/') }}" class="text-xl font-bold tracking-wide">✓ MINDERLY</a>
            <div class="py-7 lg:py-0">
                <p class="text-sm font-semibold text-blue-200">Mulai dari sini</p>
                <h1 class="mt-3 max-w-md text-3xl font-bold leading-tight sm:text-4xl">Atur tugasmu dengan lebih terarah.</h1>
                <p class="mt-4 max-w-md text-sm leading-6 text-blue-100">Buat akun untuk menyimpan tugas dan memantau tenggat.</p>
            </div>
            <p class="hidden text-xs text-blue-200 lg:block">Task Management System</p>
        </section>

        <section class="flex items-center justify-center px-5 py-10 sm:px-10 lg:px-16">
            <div class="w-full max-w-md">
                <p class="text-sm font-semibold text-blue-700">Akun baru</p>
                <h2 class="mt-2 text-2xl font-bold text-gray-900">Buat akun Minderly</h2>
                <p class="mt-2 text-sm text-gray-500">Isi detail berikut untuk memulai.</p>

                @if ($errors->any())
                    <div role="alert" class="mt-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">
                        <ul class="list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.process') }}" method="POST" class="mt-8 space-y-4">
                    @csrf
                    <div>
                        <label for="nama" class="mb-2 block text-sm font-semibold text-gray-700">Nama</label>
                        <input id="nama" name="nama" type="text" value="{{ old('nama') }}" autocomplete="name" maxlength="100" required autofocus class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                    </div>
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-gray-700">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" maxlength="100" required class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                    </div>
                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-gray-700">Password</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" minlength="8" required class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                    </div>
                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-gray-700">Konfirmasi password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" minlength="8" required class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-blue-600 focus:ring-2 focus:ring-blue-100">
                    </div>
                    <button type="submit" class="w-full rounded-xl bg-[#064B87] px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-800">Buat akun</button>
                </form>

                <p class="mt-7 text-center text-sm text-gray-500">Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-blue-700 hover:text-blue-900">Masuk</a></p>
            </div>
        </section>
    </main>
</body>
</html>