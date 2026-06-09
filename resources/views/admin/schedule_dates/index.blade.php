@extends('layouts.admin')
@section('title', 'Manajemen Jadwal')
@section('header', 'Pengaturan Tanggal Jadwal')

@section('content')

@if(session('success'))
<div class="mb-4 bg-emerald-50 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium border border-emerald-100">
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Form Tambah -->
    <div class="col-span-1">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-sm font-bold text-gray-800 mb-4">Tambah Tanggal Event</h3>
            <form action="{{ route('admin.schedule_dates.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Tanggal</label>
                    <input type="date" name="tanggal" required
                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-2.5 outline-none focus:border-[#4369a8] transition-colors">
                    @error('tanggal')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Slot Jam</label>
                    <textarea name="time_slots" rows="3" placeholder="Contoh: 08:00, 08:20, 08:40"
                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-2.5 outline-none focus:border-[#4369a8] transition-colors">08:00, 08:20, 08:40, 09:00, 09:20, 09:40, 10:00, 10:20, 10:40, 11:00, 11:20, 11:40, 13:00, 13:20, 13:40, 14:00, 14:20, 14:40</textarea>
                    <p class="text-xs text-gray-400 mt-1">Pisahkan dengan koma (format HH:mm).</p>
                    @error('time_slots')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="w-full bg-[#4369a8] text-white font-semibold py-2.5 rounded-xl hover:bg-[#355490] transition-colors text-sm">
                    Simpan Tanggal
                </button>
            </form>
        </div>
    </div>

    <!-- List Tanggal -->
    <div class="col-span-1 md:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-800">Daftar Tanggal Event</h3>
                <p class="text-xs text-gray-500 mt-1">Hanya tanggal berstatus "Aktif" yang akan muncul di halaman booking orang tua.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-xs text-gray-400 uppercase tracking-wide">
                            <th class="text-left px-6 py-3 font-semibold">Tanggal</th>
                            <th class="text-left px-4 py-3 font-semibold">Status</th>
                            <th class="text-left px-4 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($dates as $date)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-800">{{ \Carbon\Carbon::parse($date->tanggal)->translatedFormat('l, d F Y') }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ is_array($date->time_slots) ? count($date->time_slots) : 0 }} slot jam</p>
                            </td>
                            <td class="px-4 py-4">
                                @if($date->is_active)
                                <form action="{{ route('admin.schedule_dates.toggle', $date->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-emerald-100 transition-colors">Aktif</button>
                                </form>
                                @else
                                <form action="{{ route('admin.schedule_dates.toggle', $date->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-gray-100 text-gray-500 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-gray-200 transition-colors">Nonaktif</button>
                                </form>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <form action="{{ route('admin.schedule_dates.destroy', $date->id) }}" method="POST" onsubmit="return confirm('Hapus tanggal ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-400">
                                Belum ada jadwal yang ditambahkan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
