@extends('layouts.admin')
@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-6 py-4 border-b border-gray-100">
        <h2 class="text-sm font-bold text-gray-800">Semua Booking</h2>

        <div class="flex items-center gap-2 flex-wrap">
            @foreach(['all' => 'Semua', 'booked' => 'Pending', 'hadir' => 'Hadir', 'selesai' => 'Selesai'] as $key => $label)
                <a href="{{ request()->fullUrlWithQuery(['status' => $key]) }}"
                    class="px-3 py-1.5 rounded-xl text-xs font-semibold transition-colors
                        {{ request('status', 'all') === $key
                            ? 'bg-[#4369a8] text-white'
                            : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                    {{ $label }}
                </a>
            @endforeach

            <form method="GET" class="flex items-center gap-2 ml-1">
                <input type="hidden" name="status" value="{{ request('status', 'all') }}">
                <div class="flex items-center gap-2 bg-gray-100 rounded-xl px-3 py-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#9ca3af" class="w-3.5 h-3.5 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama..."
                        class="bg-transparent text-xs text-gray-700 placeholder-gray-400 outline-none w-28">
                </div>
            </form>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-400 uppercase tracking-wide">
                    <th class="text-left px-6 py-3 font-semibold">#</th>
                    <th class="text-left px-4 py-3 font-semibold">Orang Tua</th>
                    <th class="text-left px-4 py-3 font-semibold">Siswa</th>
                    <th class="text-left px-4 py-3 font-semibold">Kelas</th>
                    <th class="text-left px-4 py-3 font-semibold">Tanggal</th>
                    <th class="text-left px-4 py-3 font-semibold">Jam</th>
                    <th class="text-left px-4 py-3 font-semibold">Status</th>
                    <th class="text-left px-4 py-3 font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse ($bookings as $booking)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-gray-400 text-xs">{{ $bookings->firstItem() + $loop->index }}</td>
                    <td class="px-4 py-4">
                        <p class="font-medium text-gray-800">{{ $booking->nama_orangtua }}</p>
                    </td>
                    <td class="px-4 py-4 text-gray-600">{{ $booking->siswa->nama ?? '-' }}</td>
                    <td class="px-4 py-4">
                        <span class="bg-blue-50 text-[#4369a8] text-xs font-semibold px-2.5 py-1 rounded-lg">
                            {{ $booking->kelas->nama ?? '-' }}
                        </span>
                    </td>
                    <td class="px-4 py-4 text-gray-600 text-xs">
                        {{ \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-4 py-4 text-gray-600 text-xs">
                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $booking->jam_booking)->format('H:i') }}
                    </td>
                    <td class="px-4 py-4">
                        @php
                            $badge = match($booking->status) {
                                'hadir'   => 'bg-emerald-50 text-emerald-600',
                                'selesai' => 'bg-indigo-50 text-indigo-600',
                                default   => 'bg-amber-50 text-amber-600',
                            };
                            $label = match($booking->status) {
                                'hadir'   => 'Hadir',
                                'selesai' => 'Selesai',
                                default   => 'Pending',
                            };
                        @endphp
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-lg {{ $badge }}">{{ $label }}</span>
                    </td>
                    <td class="px-4 py-4">
                        <div class="flex items-center gap-2">
                            @if($booking->status === 'booked')
                            <form method="POST" action="{{ route('admin.bookings.confirm', $booking->id) }}">
                                @csrf @method('PATCH')
                                <button type="submit" title="Konfirmasi"
                                    class="p-1.5 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>
                                </button>
                            </form>
                            @endif

                            <form method="POST" action="{{ route('admin.bookings.destroy', $booking->id) }}"
                                onsubmit="return confirm('Hapus booking ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" title="Hapus"
                                    class="p-1.5 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-sm text-gray-400">
                        Belum ada data booking.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($bookings->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $bookings->withQueryString()->links() }}
    </div>
    @endif

</div>

@endsection