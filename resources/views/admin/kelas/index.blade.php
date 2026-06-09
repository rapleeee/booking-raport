@extends('layouts.admin')
@section('title', 'Manajemen Kelas')
@section('header', 'Kelola Kelas')

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
            <h3 class="text-sm font-bold text-gray-800 mb-4">Tambah Kelas</h3>
            <form action="{{ route('admin.kelas.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Nama Kelas</label>
                    <input type="text" name="nama" required
                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-2.5 outline-none focus:border-[#4369a8] transition-colors">
                    @error('nama')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Kode Kelas</label>
                    <input type="text" name="kode_kelas" required placeholder="Contoh: X-RPL-1"
                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-2.5 outline-none focus:border-[#4369a8] transition-colors">
                    @error('kode_kelas')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Ruangan</label>
                    <input type="text" name="ruangan" placeholder="Contoh: Ruang 101, Lab Komputer"
                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-2.5 outline-none focus:border-[#4369a8] transition-colors">
                    @error('ruangan')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Wali Kelas</label>
                    <select name="wali_kelas_id" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-2.5 outline-none focus:border-[#4369a8] transition-colors">
                        <option value="">-- Pilih Wali Kelas --</option>
                        @foreach($walis as $wali)
                            <option value="{{ $wali->id }}">{{ $wali->nama }}</option>
                        @endforeach
                    </select>
                    @error('wali_kelas_id')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-[#4369a8] text-white font-semibold py-2.5 rounded-xl hover:bg-[#355490] transition-colors text-sm">
                    Simpan Data
                </button>
            </form>
        </div>
    </div>

    <!-- List Kelas -->
    <div class="col-span-1 md:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-sm font-bold text-gray-800">Daftar Kelas</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-xs text-gray-400 uppercase tracking-wide">
                            <th class="text-left px-6 py-3 font-semibold">Nama Kelas</th>
                            <th class="text-left px-4 py-3 font-semibold">Kode Kelas</th>
                            <th class="text-left px-4 py-3 font-semibold">Ruangan</th>
                            <th class="text-left px-4 py-3 font-semibold">Wali Kelas</th>
                            <th class="text-left px-4 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($kelas as $k)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $k->nama }}</td>
                            <td class="px-4 py-4 text-gray-500">{{ $k->kode_kelas }}</td>
                            <td class="px-4 py-4 text-gray-500">{{ $k->ruangan ?? '-' }}</td>
                            <td class="px-4 py-4 text-gray-500">{{ $k->waliKelas->nama ?? '-' }}</td>
                            <td class="px-4 py-4">
                                <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Hapus kelas ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-8 text-center text-sm text-gray-400">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
