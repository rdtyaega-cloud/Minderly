<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Minderly</title>
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-[#F1F6FB] text-gray-800 antialiased">
    <main class="flex min-h-screen items-center justify-center bg-[radial-gradient(#c8d9e8_0.7px,transparent_0.7px)] bg-[size:22px_22px] px-4 py-8">
        <section class="w-full max-w-sm overflow-hidden rounded-2xl border border-white bg-white shadow-2xl shadow-[#173c5b]/10">
            <div class="h-1.5 bg-[#064B87]"></div>
            <div class="p-6 sm:p-8">
            <a href="{{ url('/') }}" class="mb-7 inline-flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#064B87] text-white shadow-sm shadow-blue-900/20">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m5 12 4 4L19 6"/>
                    </svg>
                </span>
                <span>
                    <span class="block text-sm font-extrabold tracking-wide text-gray-900">MINDERLY</span>
                    <span class="mt-0.5 block text-[11px] font-medium text-gray-500">Task Management</span>
                </span>
            </a>

            <div class="mb-6">
                <p class="text-xs font-bold uppercase tracking-wider text-blue-700">Selamat datang kembali</p>
                <h1 class="mt-2 text-2xl font-bold text-gray-900">Masuk ke akunmu</h1>
                <p class="mt-2 text-sm leading-5 text-gray-500">Lanjutkan mengatur tugas dan prioritasmu.</p>
            </div>

                @if (session('success'))
                    <div role="status" class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div role="alert" class="mb-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                        <ul class="list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-gray-700">Email</label>
                        <div class="relative">
                            <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7l9 6 9-6M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/>
                            </svg>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus placeholder="nama@email.com" class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-12 pr-4 text-sm outline-none transition placeholder:text-gray-400 focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-100">
                        </div>
                    </div>
                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-gray-700">Password</label>
                        <div class="relative">
                            <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 10V7a5 5 0 0110 0v3m-11 0h12a2 2 0 012 2v7a2 2 0 01-2 2H6a2 2 0 01-2-2v-7a2 2 0 012-2z"/>
                            </svg>
                            <input id="password" name="password" type="password" autocomplete="current-password" required placeholder="Masukkan password" class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3 pl-12 pr-12 text-sm outline-none transition placeholder:text-gray-400 focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-100">
                            <button type="button" id="togglePassword" aria-label="Tampilkan password" title="Tampilkan password" class="absolute right-2 top-1/2 flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-lg text-gray-400 transition hover:bg-gray-100 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-200">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.5 12s3.2-6 9.5-6 9.5 6 9.5 6-3.2 6-9.5 6-9.5-6-9.5-6z"/>
                                    <circle cx="12" cy="12" r="2.5" stroke-width="1.8"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="group flex w-full items-center justify-center gap-2 rounded-xl bg-[#064B87] px-5 py-3.5 text-sm font-semibold text-white shadow-sm shadow-blue-900/15 transition hover:-translate-y-0.5 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-100">
                        Masuk
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/>
                        </svg>
                    </button>
                </form>

            <p class="mt-6 border-t border-gray-100 pt-5 text-center text-sm text-gray-500">Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-blue-700 hover:text-blue-900">Daftar</a></p>
            </div>
        </section>
    </main>
    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', () => {
            const tampilkan = passwordInput.type === 'password';
            passwordInput.type = tampilkan ? 'text' : 'password';
            togglePassword.setAttribute('aria-label', tampilkan ? 'Sembunyikan password' : 'Tampilkan password');
            togglePassword.setAttribute('title', tampilkan ? 'Sembunyikan password' : 'Tampilkan password');
        });
    </script>
</body>
</html>