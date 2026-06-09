<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\WaliKelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('waliKelas')->orderBy('nama')->get();
        $walis = WaliKelas::orderBy('nama')->get();
        return view('admin.kelas.index', compact('kelas', 'walis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:kelas,nama',
            'kode_kelas' => 'required|unique:kelas,kode_kelas',
            'ruangan' => 'nullable|string|max:255',
            'wali_kelas_id' => 'required|exists:wali_kelas,id'
        ]);

        Kelas::create($request->all());
        return back()->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();
        return back()->with('success', 'Kelas berhasil dihapus.');
    }
}
