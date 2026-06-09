<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Wali Kelas</title>
    @vite('resources/css/app.css')
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
        
        @if(session('success'))
        <div class="mb-6 bg-emerald-50 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium border border-emerald-100 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            {{ session('success') }}
        </div>
        @endif

        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800">Daftar Antrean (Hadir)</h2>
            <span class="bg-indigo-50 text-indigo-600 text-xs font-bold px-3 py-1 rounded-full border border-indigo-100">
                Hari ini: {{ date('d M Y') }}
            </span>
        </div>

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
                            <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2.5 px-6 rounded-xl transition-colors shadow-md shadow-indigo-500/20 text-sm">
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

    </main>

</body>
</html>
