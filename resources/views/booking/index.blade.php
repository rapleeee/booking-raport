<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Take Raport</title>
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
    @theme {
        --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
    }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <style>
        .date-scroll::-webkit-scrollbar {
            display: none;
        }

        .date-scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .date-card.active {
            background-color: #4369a8;
            color: white;
        }

        .date-card.active .day-name,
        .date-card.active .date-num {
            color: white;
        }

        .time-chip.active {
            background-color: #4369a8;
            color: white;
        }

        .ts-wrapper .ts-control {
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            background: transparent !important;
            font-size: 0.875rem;
            color: #374151;
        }

        .ts-wrapper.focus .ts-control {
            box-shadow: none !important;
        }

        .ts-wrapper {
            flex: 1;
        }

        .ts-dropdown {
            border-radius: 1rem;
            margin-top: 8px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        }

        .ts-dropdown .option {
            padding: 10px 16px;
            font-size: 0.875rem;
        }

        .ts-dropdown .option:hover,
        .ts-dropdown .option.active {
            background-color: #eef2fa;
            color: #4369a8;
        }

        .ts-dropdown .option.selected {
            background-color: #4369a8;
            color: white;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="p-5">
        <a href="{{ url('booking/class') }}"
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



        <form method="POST" action="{{ route('booking.postCreate') }}" id="bookingForm">
            @csrf

            <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3">Isi Data Anda</p>

            <div class="flex gap-2 mb-8">
                <div class="h-1 flex-1 rounded-full bg-[#4369a8]"></div>
                <div class="h-1 flex-1 rounded-full bg-[#4369a8]"></div>
                <div class="h-1 flex-1 rounded-full bg-gray-200"></div>
                <div class="h-1 flex-1 rounded-full bg-gray-200"></div>
            </div>

            <div class="flex flex-col gap-3 mb-8">
                <div
                    class="flex items-center gap-3 bg-white border border-gray-200 rounded-2xl px-4 py-3 shadow-sm focus-within:border-[#4369a8] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="#4369a8" class="w-5 h-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <input type="text" name="nama_orangtua" id="input_nama_ortu" value="{{ old('nama_orangtua') }}"
                        class="flex-1 bg-transparent text-sm text-gray-700 placeholder-gray-400 outline-none"
                        placeholder="Nama Orang Tua">
                    <button type="button" onclick="document.getElementById('input_nama_ortu').value=''"
                        class="text-gray-300 hover:text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                @error('nama_orangtua')
                    <p class="text-xs text-red-500 -mt-2 pl-2">{{ $message }}</p>
                @enderror

                <div
                    class="flex items-center gap-3 bg-white border border-gray-200 rounded-2xl px-4 py-3 shadow-sm focus-within:border-[#4369a8] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="#4369a8" class="w-5 h-5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    <select name="siswa_id" id="select_siswa" placeholder="Cari nama anak...">
                        <option value="">-- Pilih Nama Anak --</option>
                        @foreach ($siswas as $siswa)
                            <option value="{{ $siswa->id }}" {{ old('siswa_id') == $siswa->id ? 'selected' : '' }}>
                                {{ $siswa->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('siswa_id')
                    <p class="text-xs text-red-500 -mt-2 pl-2">{{ $message }}</p>
                @enderror

            </div>

            <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3">Pilih Tanggal</p>
            <div class="date-scroll flex gap-2 overflow-x-auto pb-2 mb-8">
                @php
                    $days = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
                @endphp
                @forelse ($scheduleDates as $index => $scheduleDate)
                    @php 
                        $date = \Carbon\Carbon::parse($scheduleDate->tanggal); 
                        $isActive = $index === 0;
                    @endphp
                    <div class="date-card flex flex-col items-center px-4 py-3 rounded-2xl border border-gray-200 shadow-sm cursor-pointer min-w-14 {{ $isActive ? 'active' : 'bg-white' }}"
                        data-date="{{ $date->format('Y-m-d') }}" onclick="selectDate(this)">
                        <span
                            class="day-name text-[10px] font-semibold {{ $isActive ? 'text-white' : 'text-gray-400' }} uppercase">
                            {{ $days[$date->dayOfWeek] }}
                        </span>
                        <span class="date-num text-lg font-bold {{ $isActive ? 'text-white' : 'text-gray-800' }}">
                            {{ $date->format('d') }}
                        </span>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">Tidak ada jadwal yang tersedia.</p>
                @endforelse
            </div>
            <input type="hidden" name="tanggal_booking" id="input_tanggal" value="{{ $scheduleDates->first()->tanggal ?? '' }}">
            @error('tanggal_booking')
                <p class="text-xs text-red-500 -mt-6 mb-4 pl-2">{{ $message }}</p>
            @enderror

            <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3">Pilih Jam</p>
            <div id="slots_container" class="grid grid-cols-3 gap-2 mb-8">
                <!-- Slots will be populated by JS -->
            </div>
            <input type="hidden" name="jam_booking" id="input_jam" value="">
            @error('jam_booking')
                <p class="text-xs text-red-500 -mt-6 mb-4 pl-2">{{ $message }}</p>
            @enderror

        </form>
    </div>
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 px-5 py-4">
        <div class="max-w-xl mx-auto">
            <button type="submit" form="bookingForm"
                class="w-full bg-[#4369a8] text-white font-semibold py-4 rounded-2xl hover:bg-[#355490] active:scale-95 transition-all duration-150 text-sm">
                Selanjutnya
            </button>
        </div>
    </div>

    <script>
        new TomSelect('#select_siswa', {
            placeholder: 'Cari nama anak...',
            allowEmptyOption: false,
        });

        document.addEventListener('DOMContentLoaded', function() {
            const firstDate = document.getElementById('input_tanggal').value;
            if (firstDate) {
                fetchSlots(firstDate);
            }
        });

        function fetchSlots(date) {
            const container = document.getElementById('slots_container');
            container.innerHTML = '<p class="text-sm text-gray-400 col-span-3 text-center py-2">Loading slots...</p>';
            
            fetch(`/booking/slots?tanggal=${date}`)
                .then(res => res.json())
                .then(slots => {
                    container.innerHTML = '';
                    if(slots.length === 0) {
                        container.innerHTML = '<p class="text-sm text-red-500 col-span-3 text-center py-2">Tidak ada jadwal tersedia</p>';
                        document.getElementById('input_jam').value = '';
                        return;
                    }

                    let firstSlot = true;
                    slots.forEach(slotData => {
                        const time = slotData.time.substring(0, 5); // 08:00
                        const isBooked = slotData.is_booked;
                        
                        const div = document.createElement('div');
                        
                        if (isBooked) {
                            div.className = `text-center py-3 rounded-2xl border border-gray-200 shadow-sm text-sm font-semibold bg-gray-100 text-gray-400 opacity-60 cursor-not-allowed`;
                            div.innerText = time;
                            // Do not add onclick or data-jam
                        } else {
                            div.className = `time-chip text-center py-3 rounded-2xl border border-gray-200 shadow-sm text-sm font-semibold cursor-pointer ${firstSlot ? 'active' : 'bg-white text-gray-700'}`;
                            div.dataset.jam = time;
                            div.onclick = function() { selectTime(this) };
                            div.innerText = time;
                            
                            if(firstSlot) {
                                document.getElementById('input_jam').value = time;
                                firstSlot = false;
                            }
                        }
                        
                        container.appendChild(div);
                    });
                    
                    if (firstSlot) {
                        // Means all slots were booked
                        document.getElementById('input_jam').value = '';
                    }
                });
        }

        function selectDate(el) {
            document.querySelectorAll('.date-card').forEach(d => {
                d.classList.remove('active');
                d.classList.add('bg-white', 'border', 'border-gray-200');
                d.querySelector('.day-name').classList.remove('text-white');
                d.querySelector('.day-name').classList.add('text-gray-400');
                d.querySelector('.date-num').classList.remove('text-white');
                d.querySelector('.date-num').classList.add('text-gray-800');
            });
            el.classList.add('active');
            el.classList.remove('bg-white', 'border', 'border-gray-200');
            el.querySelector('.day-name').classList.add('text-white');
            el.querySelector('.day-name').classList.remove('text-gray-400');
            el.querySelector('.date-num').classList.add('text-white');
            el.querySelector('.date-num').classList.remove('text-gray-800');

            const selectedDate = el.dataset.date;
            document.getElementById('input_tanggal').value = selectedDate;
            fetchSlots(selectedDate);
        }

        function selectTime(el) {
            document.querySelectorAll('.time-chip').forEach(t => {
                t.classList.remove('active');
                t.classList.add('bg-white', 'border', 'border-gray-200', 'text-gray-700');
            });
            el.classList.add('active');
            el.classList.remove('bg-white', 'border', 'border-gray-200', 'text-gray-700');

            document.getElementById('input_jam').value = el.dataset.jam;
        }
    </script>

</body>

</html>