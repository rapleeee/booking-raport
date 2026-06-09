@extends('layouts.admin')
@section('title', 'Manajemen Siswa')
@section('header', 'Kelola Siswa')

@section('content')

@if(session('success'))
<div class="mb-4 bg-emerald-50 text-emerald-600 px-4 py-3 rounded-xl text-sm font-medium border border-emerald-100">
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Form Tambah -->
    <div class="col-span-1 space-y-6">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-sm font-bold text-gray-800 mb-4">Tambah Siswa Manual</h3>
            <form action="{{ route('admin.siswa.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Nama Siswa</label>
                    <input type="text" name="nama" required
                        class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-2.5 outline-none focus:border-[#4369a8] transition-colors">
                    @error('nama')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Kelas</label>
                    <select name="kelas_id" required class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-2.5 outline-none focus:border-[#4369a8] transition-colors">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-[#4369a8] text-white font-semibold py-2.5 rounded-xl hover:bg-[#355490] transition-colors text-sm">
                    Simpan Data
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-sm font-bold text-gray-800 mb-4">Import Data Siswa</h3>
            <p class="text-xs text-gray-500 mb-4">Download template Excel (.xlsx), isi data, lalu upload kembali untuk memasukkan data secara massal.</p>
            
            <a href="{{ route('admin.siswa.template') }}" class="block w-full text-center bg-gray-100 text-gray-700 font-semibold py-2.5 rounded-xl hover:bg-gray-200 transition-colors text-sm mb-4">
                1. Download Template Excel
            </a>

            <form action="{{ route('admin.siswa.import.preview') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">2. Upload File (.xlsx)</label>
                    <input type="file" name="file" accept=".xlsx,.xls,.csv" required
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                    @error('file')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-emerald-600 text-white font-semibold py-2.5 rounded-xl hover:bg-emerald-700 transition-colors text-sm">
                    Preview Import
                </button>
            </form>
        </div>
    </div>


    <!-- List Siswa -->
    <div class="col-span-1 md:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-sm font-bold text-gray-800">Daftar Siswa</h3>
                
                <form method="GET" class="flex gap-2">
                    <select name="kelas_id" class="bg-gray-50 border border-gray-200 text-gray-700 text-xs rounded-xl px-3 py-1.5 outline-none" onchange="this.form.submit()">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-xs text-gray-400 uppercase tracking-wide">
                            <th class="text-left px-6 py-3 font-semibold">Nama Siswa</th>
                            <th class="text-left px-4 py-3 font-semibold">Kelas</th>
                            <th class="text-left px-4 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($siswa as $s)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $s->nama }}</td>
                            <td class="px-4 py-4 text-gray-500">
                                <span class="bg-indigo-50 text-indigo-600 px-2 py-1 rounded-md text-xs font-semibold">{{ $s->kelas->nama ?? '-' }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus siswa ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="px-6 py-8 text-center text-sm text-gray-400">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($siswa->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $siswa->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
