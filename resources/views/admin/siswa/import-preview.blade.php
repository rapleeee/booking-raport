@extends('layouts.admin')
@section('title', 'Preview Import Siswa')
@section('header', 'Preview Import Data')

@section('content')

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
        <div>
            <h3 class="text-sm font-bold text-gray-800">Preview Data Siswa ({{ count($previewData) }} Baris)</h3>
            <p class="text-xs text-gray-500 mt-1">Harap periksa kembali data di bawah ini sebelum menekan tombol Proses Import.</p>
        </div>
        
        <form action="{{ route('admin.siswa.import.process') }}" method="POST" class="flex gap-2">
            @csrf
            <a href="{{ route('admin.siswa.index') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-lg text-sm font-semibold hover:bg-gray-50 transition-colors">Batal</a>
            
            @php
                $hasError = collect($previewData)->contains('can_import', false);
            @endphp
            
            @if($hasError)
                <button type="button" disabled class="px-4 py-2 bg-gray-300 text-gray-500 rounded-lg text-sm font-semibold cursor-not-allowed">Ada Error Kelas</button>
            @else
                <button type="submit" class="px-4 py-2 bg-[#4369a8] text-white rounded-lg text-sm font-semibold hover:bg-[#355490] transition-colors">Proses Import</button>
            @endif
        </form>
    </div>
    
    @if($hasError)
        <div class="px-6 py-3 bg-red-50 border-b border-red-100 text-red-600 text-xs font-semibold">
            Terdapat Nama Kelas pada data Excel yang belum terdaftar di master data Kelas. Silakan tambahkan nama kelas tersebut di menu "Kelas" terlebih dahulu atau perbaiki pengetikan di file Excel Anda!
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-xs text-gray-400 uppercase tracking-wide">
                    <th class="text-left px-6 py-3 font-semibold">No</th>
                    <th class="text-left px-4 py-3 font-semibold">Nama Siswa</th>
                    <th class="text-left px-4 py-3 font-semibold">Nama Kelas (di File)</th>
                    <th class="text-left px-4 py-3 font-semibold">Status Validasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($previewData as $index => $row)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-3 text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $row['nama_siswa'] }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $row['nama_kelas'] }}</td>
                    <td class="px-4 py-3">
                        @if($row['can_import'])
                            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-600">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Siap Import
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-lg text-xs font-semibold bg-red-50 text-red-600">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Kelas Tidak Ditemukan
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-8 text-center text-sm text-gray-400">File kosong atau format salah.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
