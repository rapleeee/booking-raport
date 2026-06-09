<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WaliKelas;
use Illuminate\Http\Request;

class WaliKelasController extends Controller
{
    public function index()
    {
        $walis = WaliKelas::orderBy('nama')->get();
        return view('admin.walikelas.index', compact('walis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'pin' => 'required|unique:wali_kelas,pin'
        ]);

        WaliKelas::create($request->all());
        return back()->with('success', 'Wali Kelas berhasil ditambahkan.');
    }

    public function destroy(WaliKelas $walikela)
    {
        $walikela->delete();
        return back()->with('success', 'Wali Kelas berhasil dihapus.');
    }
}
