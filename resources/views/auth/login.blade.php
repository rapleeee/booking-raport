<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Booking</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center px-5 relative">

    <div class="absolute inset-0 z-0">
        <img src="{{ asset('./img/bg-sekolah.webp') }}" alt="background sekolah" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    </div>

    <div class="w-full max-w-sm relative z-10">

        <div class="flex flex-col items-center mb-8">
            <h1 class="text-2xl font-bold text-white">Selamat Datang</h1>
            <p class="text-sm text-white/60 mt-1">Masuk ke Sistem Booking Raport</p>
        </div>
        @if (session('status'))
            <div class="bg-green-500/20 border border-green-400/40 text-green-300 text-sm rounded-2xl px-4 py-3 mb-4">
                {{ session('status') }}
            </div>
        @endif
        <div class="bg-white/90 backdrop-blur-md rounded-3xl shadow-lg border border-white/50 px-6 py-8">

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="flex flex-col gap-4">
                    <div>
                        <label for="email"
                            class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Email</label>
                        <div
                            class="flex items-center gap-3 bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 focus-within:border-[#4369a8] focus-within:bg-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="#4369a8" class="w-5 h-5 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                autocomplete="username" placeholder="email@contoh.com"
                                class="flex-1 bg-transparent text-sm text-gray-700 placeholder-gray-400 outline-none">
                        </div>
                        @error('email')
                            <p class="text-xs text-red-500 mt-1.5 pl-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password"
                            class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Password</label>
                        <div
                            class="flex items-center gap-3 bg-gray-50 border border-gray-200 rounded-2xl px-4 py-3 focus-within:border-[#4369a8] focus-within:bg-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="#4369a8" class="w-5 h-5 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                            <input id="password" type="password" name="password" required
                                autocomplete="current-password" placeholder="••••••••"
                                class="flex-1 bg-transparent text-sm text-gray-700 placeholder-gray-400 outline-none">
                            <button type="button" onclick="togglePassword()"
                                class="text-gray-300 hover:text-[#4369a8] transition-colors">
                                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-500 mt-1.5 pl-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="w-4 h-4 rounded border-gray-300 text-[#4369a8] focus:ring-[#4369a8]">
                            <span class="text-xs text-gray-500">Ingat saya</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-xs text-[#4369a8] hover:underline font-medium">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <button type="submit"
                        class="w-full bg-[#4369a8] text-white font-semibold py-3.5 rounded-2xl hover:bg-[#355490] active:scale-95 transition-all duration-150 text-sm mt-2">
                        Masuk
                    </button>

                </div>
            </form>

        </div>

        <p class="text-center text-xs text-white/40 mt-6">
            Sistem Booking Pengambilan Raport
        </p>

    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>

</html>