<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Wali Kelas - Booking Raport</title>

    <!-- SEO & Favicon -->
    <meta name="description" content="Sistem Antrean dan Pengambilan Raport SMK Pesat IT Xpro. Solusi cerdas penjadwalan kehadiran orang tua secara digital.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Dashboard Wali Kelas - SMK Pesat IT Xpro">
    <meta property="og:description" content="Sistem Antrean dan Pengambilan Raport SMK Pesat IT Xpro. Solusi cerdas penjadwalan kehadiran orang tua secara digital.">
    <meta property="og:image" content="{{ asset('logo.png') }}">
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Dashboard Wali Kelas - SMK Pesat IT Xpro">
    <meta property="twitter:description" content="Sistem Antrean dan Pengambilan Raport SMK Pesat IT Xpro. Solusi cerdas penjadwalan kehadiran orang tua secara digital.">
    <meta property="twitter:image" content="{{ asset('logo.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    @vite('resources/css/app.css')
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
    @theme {
        --font-sans: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
    }
    </style>
    <meta http-equiv="refresh" content="30">
</head>
<body class="bg-gray-50 min-h-screen">

    <header class="bg-white border-b border-gray-200 sticky top-0 z-10 shadow-sm">
        <div class="max-w-4xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xl">
                    {{ substr($wali->nama, 0, 1) }}
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-800">{{ $wali->nama }}</h1>
                    <p class="text-sm text-gray-500">{{ $wali->kelas->pluck('nama')->join(', ') }}</p>
                </div>
            </div>
            <div>
                <a href="{{ route('wali.login') }}" class="text-sm font-semibold text-gray-400 hover:text-gray-600">Keluar</a>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-8">
        


        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800">Daftar Antrean (Hadir)</h2>
            <span class="bg-indigo-50 text-indigo-600 text-xs font-bold px-3 py-1 rounded-full border border-indigo-100">
                Hari ini: {{ date('d M Y') }}
            </span>
        </div>
        
        @php
            $isCallingAny = $bookings->contains('status', 'dipanggil');
        @endphp

        @if($isCallingAny)
            <div class="mb-6 bg-amber-50 border border-amber-200 text-amber-700 px-4 py-3 rounded-xl text-sm flex items-center gap-3 shadow-sm">
                <svg class="w-5 h-5 shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p><strong>Ada tamu yang sedang dilayani.</strong> Anda harus menyelesaikan tamu saat ini sebelum memanggil tamu berikutnya.</p>
            </div>
        @endif

        <div class="space-y-4">
            @forelse($bookings as $booking)
                <div class="bg-white rounded-2xl p-5 border {{ in_array($booking->status, ['hadir', 'dipanggil']) ? 'border-indigo-100 shadow-sm' : 'border-gray-100 opacity-60' }} flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full {{ in_array($booking->status, ['hadir', 'dipanggil']) ? 'bg-indigo-50 text-indigo-600' : 'bg-gray-50 text-gray-400' }} flex items-center justify-center font-bold">
                            {{ $loop->iteration }}
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">{{ $booking->nama_orangtua }}</h3>
                            <p class="text-sm text-gray-500">Orang tua dari: <span class="font-semibold text-gray-700">{{ $booking->siswa->nama }}</span></p>
                            <div class="flex items-center gap-3 mt-2">
                                <span class="text-xs font-medium text-gray-400 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ date('H:i', strtotime($booking->jam_booking)) }}
                                </span>
                                @if($booking->status === 'dipanggil')
                                    <span class="text-xs font-bold text-amber-500 bg-amber-50 px-2 py-0.5 rounded uppercase">Sedang Dipanggil</span>
                                @elseif($booking->status === 'selesai')
                                    <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded uppercase">Selesai</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($booking->status === 'hadir')
                    <div class="flex items-center gap-2">
                        <form action="{{ route('wali.panggil', $booking->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                {{ $isCallingAny ? 'disabled' : '' }}
                                class="w-full sm:w-auto bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2.5 px-6 rounded-xl transition-colors shadow-md shadow-indigo-500/20 text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                Panggil Tamu
                            </button>
                        </form>
                    </div>
                    @elseif($booking->status === 'dipanggil')
                    <div class="flex items-center gap-2">
                        <form action="{{ route('wali.selesai', $booking->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2.5 px-6 rounded-xl transition-colors shadow-md shadow-emerald-500/20 text-sm">
                                Tandai Selesai
                            </button>
                        </form>
                    </div>
                    @endif

                </div>
            @empty
                <div class="text-center py-16 bg-white rounded-3xl border border-dashed border-gray-300">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    <h3 class="text-gray-500 font-medium">Belum ada antrean yang hadir.</h3>
                    <p class="text-sm text-gray-400 mt-1">Halaman ini akan otomatis refresh setiap 30 detik.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-12 mb-6 border-t border-gray-200 pt-8">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Seluruh Data Pendaftar</h2>
            <p class="text-sm text-gray-500 mb-6">Daftar ini berisi seluruh orang tua/siswa yang sudah melakukan <strong>booking</strong>, terlepas dari apakah mereka sudah hadir atau belum. Gunakan daftar ini untuk mengingatkan mereka yang belum membooking.</p>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-xs text-gray-400 uppercase tracking-wide">
                                <th class="text-left px-6 py-4 font-semibold">No</th>
                                <th class="text-left px-6 py-4 font-semibold">Nama Siswa</th>
                                <th class="text-left px-6 py-4 font-semibold">Orang Tua</th>
                                <th class="text-left px-6 py-4 font-semibold">Jadwal</th>
                                <th class="text-left px-6 py-4 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($allBookings as $index => $b)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $b->siswa->nama }}
                                    <div class="text-xs text-indigo-500 mt-1">{{ $b->kelas->nama }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $b->nama_orangtua }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-800 font-medium">{{ \Carbon\Carbon::parse($b->tanggal_booking)->translatedFormat('d M Y') }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ date('H:i', strtotime($b->jam_booking)) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($b->status === 'booking')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">Menunggu Kehadiran</span>
                                    @elseif($b->status === 'hadir')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">Hadir (Antre)</span>
                                    @elseif($b->status === 'dipanggil')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">Sedang Dipanggil</span>
                                    @elseif($b->status === 'selesai')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Selesai</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-50 text-gray-700 border border-gray-100">{{ ucfirst($b->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">Belum ada orang tua yang mendaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session("success") }}',
                    confirmButtonColor: '#4f46e5',
                    timer: 3000,
                    timerProgressBar: true
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session("error") }}',
                    confirmButtonColor: '#4f46e5',
                });
            @endif
        </script>
    </main>

</body>
</html>
