<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Kelas</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
    @theme {
        --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
    }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="p-5">
        <a href="{{ route('booking.index') }}"
            class="bg-white shadow rounded-full p-2 inline-flex items-center justify-center hover:bg-gray-100 active:scale-95 transition-all duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#4369a8"
                class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
            </svg>
        </a>
    </div>

    <div class="container mx-auto px-5 pb-32 max-w-xl">
        <h1 class="text-3xl text-gray-800 leading-tight mb-1">Book</h1>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Appointment</h1>
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-6">Pilih kelas ananda ayah dan bunda
        </p>

        <div class="flex gap-2 mb-8">
            <div class="h-1 flex-1 rounded-full bg-[#4369a8]"></div>
            <div class="h-1 flex-1 rounded-full bg-gray-200"></div>
            <div class="h-1 flex-1 rounded-full bg-gray-200"></div>
            <div class="h-1 flex-1 rounded-full bg-gray-200"></div>
        </div>

        <form method="POST" action="{{ route('booking.postClass') }}" id="classForm">
            @csrf

            <div class="flex flex-col gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Kelas
                        Ananda</label>
                    <div
                        class="flex items-center gap-3 bg-white border border-gray-200 rounded-2xl px-4 py-3 shadow-sm focus-within:border-[#4369a8] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="#4369a8" class="w-5 h-5 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 3.741-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>
                        <select id="select_kelas" name="kelas_id"
                            class="flex-1 bg-transparent text-sm text-gray-700 outline-none cursor-pointer appearance-none">
                            <option value="" disabled selected>-- Pilih Kelas --</option>
                            @foreach ($kelas as $k)
                                <option value="{{ $k->id }}" data-wali-id="{{ $k->waliKelas->id ?? '' }}"
                                    data-wali-nama="{{ $k->waliKelas->nama ?? '-' }}">
                                    {{ $k->nama }} ({{ $k->kode_kelas }})
                                </option>
                            @endforeach
                        </select>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="#9ca3af" class="w-4 h-4 shrink-0 pointer-events-none">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                    @error('kelas_id')
                        <p class="text-xs text-red-500 mt-1 pl-2">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Wali
                        Kelas</label>
                    <div
                        class="flex items-center gap-3 bg-white border border-gray-200 rounded-2xl px-4 py-3 shadow-sm focus-within:border-[#4369a8] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="#4369a8" class="w-5 h-5 shrink-0">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <select id="select_wali" name="wali_kelas_id"
                            class="flex-1 bg-transparent text-sm text-gray-700 outline-none cursor-pointer appearance-none">
                            <option value="" disabled selected>-- Pilih Wali Kelas --</option>
                            @foreach ($kelas as $k)
                                @if ($k->waliKelas)
                                    <option value="{{ $k->waliKelas->id }}" data-kelas-id="{{ $k->id }}"
                                        data-kelas-nama="{{ $k->nama }} ({{ $k->kode_kelas }})">
                                        {{ $k->waliKelas->nama }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="#9ca3af" class="w-4 h-4 shrink-0 pointer-events-none">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                    @error('wali_kelas_id')
                        <p class="text-xs text-red-500 mt-1 pl-2">{{ $message }}</p>
                    @enderror
                </div>

            </div>
        </form>

    </div>

    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 px-5 py-4">
        <div class="max-w-xl mx-auto">
            <button type="submit" form="classForm"
                class="w-full bg-[#4369a8] text-white font-semibold py-4 rounded-2xl hover:bg-[#355490] active:scale-95 transition-all duration-150 text-sm">
                Selanjutnya
            </button>
        </div>
    </div>

    <script>
        const selectKelas = document.getElementById('select_kelas');
        const selectWali = document.getElementById('select_wali');
        const infoCard = document.getElementById('info_card');
        const infoText = document.getElementById('info_text');

        selectKelas.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            const waliId = selected.dataset.waliId;
            const waliNama = selected.dataset.waliNama;
            const kelasNama = selected.text;
            for (let opt of selectWali.options) {
                if (opt.value == waliId) {
                    opt.selected = true;
                    break;
                }
            }

            showInfo(kelasNama, waliNama);
        });

        selectWali.addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            const kelasId = selected.dataset.kelasId;
            const kelasNama = selected.dataset.kelasNama;
            const waliNama = selected.text;

            for (let opt of selectKelas.options) {
                if (opt.value == kelasId) {
                    opt.selected = true;
                    break;
                }
            }

            showInfo(kelasNama, waliNama);
        });

        function showInfo(kelasNama, waliNama) {
            infoText.textContent = kelasNama + ' · Wali Kelas: ' + waliNama;
            infoCard.classList.remove('hidden');
        }
    </script>

</body>

</html>