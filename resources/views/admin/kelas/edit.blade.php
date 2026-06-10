@extends('layouts.admin')
@section('title', 'Edit Kelas')
@section('header', 'Edit Kelas')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-800">Edit Data Kelas</h3>
            <a href="{{ route('admin.kelas.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 transition">
                Kembali
            </a>
        </div>

        <form action="{{ route('admin.kelas.update', $kela->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Kode Kelas</label>
                <input type="text" name="kode_kelas" value="{{ old('kode_kelas', $kela->kode_kelas) }}" required
                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-2.5 outline-none focus:border-[#4369a8] transition-colors">
                @error('kode_kelas')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Nama Kelas</label>
                <input type="text" name="nama" value="{{ old('nama', $kela->nama) }}" required
                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-2.5 outline-none focus:border-[#4369a8] transition-colors">
                @error('nama')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Ruangan</label>
                <input type="text" name="ruangan" value="{{ old('ruangan', $kela->ruangan) }}" placeholder="Opsional"
                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-2.5 outline-none focus:border-[#4369a8] transition-colors">
                @error('ruangan')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Wali Kelas</label>
                <select name="wali_kelas_id" required
                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-2.5 outline-none focus:border-[#4369a8] transition-colors">
                    <option value="">-- Pilih Wali Kelas --</option>
                    @foreach($walis as $wali)
                        <option value="{{ $wali->id }}" {{ old('wali_kelas_id', $kela->wali_kelas_id) == $wali->id ? 'selected' : '' }}>
                            {{ $wali->nama }}
                        </option>
                    @endforeach
                </select>
                @error('wali_kelas_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit"
                class="w-full bg-[#4369a8] text-white font-semibold py-2.5 rounded-xl hover:bg-[#355490] transition-colors text-sm">
                Update Data
            </button>
        </form>
    </div>
</div>
@endsection
