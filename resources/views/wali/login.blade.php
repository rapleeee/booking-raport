<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Wali Kelas</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-sm bg-white rounded-3xl shadow-xl overflow-hidden p-8 border border-gray-100">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-50 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#4f46e5" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Wali Kelas</h1>
            <p class="text-sm text-gray-500 mt-1">Masukkan PIN untuk mengakses kelas Anda</p>
        </div>

        <form action="{{ route('wali.postLogin') }}" method="POST">
            @csrf
            <div class="mb-6">
                <input type="password" name="pin" required placeholder="••••••"
                    class="w-full text-center text-3xl tracking-[0.5em] bg-gray-50 border border-gray-200 rounded-2xl px-4 py-4 outline-none focus:border-indigo-500 transition-colors shadow-inner">
                @error('pin')
                    <p class="text-xs text-red-500 mt-2 text-center">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-2xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200">
                Masuk
            </button>
        </form>
    </div>

</body>
</html>
