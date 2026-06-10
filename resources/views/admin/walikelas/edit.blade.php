@extends('layouts.admin')
@section('title', 'Edit Wali Kelas')
@section('header', 'Edit Wali Kelas')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-800">Edit Data Wali Kelas</h3>
            <a href="{{ route('admin.walikelas.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700 transition">
                Kembali
            </a>
        </div>

        <form action="{{ route('admin.walikelas.update', $walikela->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Nama Wali Kelas</label>
                <input type="text" name="nama" value="{{ old('nama', $walikela->nama) }}" required
                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-2.5 outline-none focus:border-[#4369a8] transition-colors">
                @error('nama')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-6">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">PIN</label>
                <input type="text" name="pin" value="{{ old('pin', $walikela->pin) }}" required maxlength="6"
                    class="w-full bg-gray-50 border border-gray-200 text-gray-800 rounded-xl px-4 py-2.5 outline-none focus:border-[#4369a8] transition-colors">
                @error('pin')
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
