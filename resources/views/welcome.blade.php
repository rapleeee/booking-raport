<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Take Raport</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center px-5 relative">
    <div class="absolute inset-0 z-0">
        <img src="{{ asset('./img/bg-sekolah.webp') }}" alt="background sekolah" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
    </div>
    <div class="w-full max-w-sm relative z-10 mx-auto px-6 min-h-screen flex items-center justify-center">
        <div class="text-center max-w-xl">
            <img src="{{ asset('img/onboarding.svg') }}" alt="Onboarding"
                class="w-full max-w-sm sm:max-w-sm md:max-w-md mx-auto">
            <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-100 mb-2">
                Ambil Raport Jadi Mudah
            </h1>

            <p class="text-gray-300 text-sm md:text-base leading-relaxed mb-4">
                Tentukan jadwal kedatangan Anda hanya dalam beberapa langkah.
                Cepat, praktis dan tau kapan harus datang.
            </p>
            <a href="{{ route('booking.class') }}">
                <button
                    class="mt-2 w-full bg-[#4369a8] text-white text-sm md:text-base font-medium py-3 px-6 rounded-xl hover:bg-[#355490] active:scale-99 transition-all duration-150">
                    Booking Sekarang
                </button>
            </a>
        </div>
    </div>
</body>

</html>