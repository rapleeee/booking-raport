@extends('layouts.admin')
@section('title', 'Laporan Booking')
@section('header', 'Laporan')

@section('content')

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="text-sm font-bold text-gray-800">Filter Laporan</h3>
    </div>
    <div class="p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Tanggal Event</label>
                <select name="tanggal_booking" class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-xl px-4 py-2.5 outline-none focus:border-[#4369a8]">
                    <option value="">Semua Tanggal</option>
                    @foreach($dates as $date)
                        <option value="{{ $date->tanggal }}" {{ request('tanggal_booking') == $date->tanggal ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::parse($date->tanggal)->translatedFormat('d M Y') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Kelas</label>
                <select name="kelas_id" class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-xl px-4 py-2.5 outline-none focus:border-[#4369a8]">
                    <option value="">Semua Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Status</label>
                <select name="status" class="w-full bg-gray-50 border border-gray-200 text-gray-700 rounded-xl px-4 py-2.5 outline-none focus:border-[#4369a8]">
                    <option value="">Semua Status</option>
                    <option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>Booked</option>
                    <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="w-full bg-[#4369a8] text-white font-semibold py-2.5 rounded-xl hover:bg-[#355490] transition-colors text-sm">Filter</button>
                <a href="{{ route('admin.reports.index') }}" class="w-full text-center bg-gray-100 text-gray-600 font-semibold py-2.5 rounded-xl hover:bg-gray-200 transition-colors text-sm">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-sm font-bold text-gray-800">Data Booking ({{ $bookings->count() }} data)</h3>
        <button onclick="window.print()" class="text-sm font-semibold text-[#4369a8] bg-blue-50 px-4 py-2 rounded-xl hover:bg-blue-100 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Print Laporan
        </button>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm print:text-xs">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-400 uppercase tracking-wide">
                    <th class="text-left px-6 py-3 font-semibold">Kode Booking</th>
                    <th class="text-left px-4 py-3 font-semibold">Orang Tua</th>
                    <th class="text-left px-4 py-3 font-semibold">Siswa</th>
                    <th class="text-left px-4 py-3 font-semibold">Kelas</th>
                    <th class="text-left px-4 py-3 font-semibold">Jadwal</th>
                    <th class="text-left px-4 py-3 font-semibold">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($bookings as $booking)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-mono font-semibold text-gray-600 text-xs">{{ $booking->unique_code }}</td>
                    <td class="px-4 py-4 font-medium text-gray-800">{{ $booking->nama_orangtua }}</td>
                    <td class="px-4 py-4 text-gray-600">{{ $booking->siswa->nama ?? '-' }}</td>
                    <td class="px-4 py-4">
                        <span class="bg-indigo-50 text-indigo-600 text-xs font-semibold px-2 py-1 rounded-md">{{ $booking->kelas->nama ?? '-' }}</span>
                    </td>
                    <td class="px-4 py-4 text-gray-600 text-xs">
                        {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d/m/Y') }}<br>
                        <span class="font-bold text-gray-800">{{ date('H:i', strtotime($booking->jam_booking)) }}</span>
                    </td>
                    <td class="px-4 py-4">
                        @php
                            $badge = match($booking->status) {
                                'booked'   => 'bg-amber-50 text-amber-600',
                                'hadir'    => 'bg-blue-50 text-blue-600',
                                'selesai'  => 'bg-emerald-50 text-emerald-600',
                                default    => 'bg-gray-50 text-gray-600',
                            };
                        @endphp
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-lg uppercase {{ $badge }}">{{ $booking->status }}</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-sm text-gray-400">Data laporan kosong.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    @media print {
        body { background: white; }
        aside, header, form, button.print\:hidden, a { display: none !important; }
        .bg-white { box-shadow: none !important; border: none !important; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border-bottom: 1px solid #eee; }
        main { padding: 0 !important; }
    }
</style>
@endsection
