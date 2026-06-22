<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Kelas;

class displayController extends Controller
{
    public function index()
    {
        return view('display.index');
    }

    public function data()
    {
        // Booking yang sedang dipanggil
        $bookings = Booking::with(['siswa', 'kelas'])
            ->where('status', 'dipanggil')
            ->orderBy('jam_booking', 'asc')
            ->get();

        // Booking yang sudah check-in (hadir) - menunggu dipanggil
        $hadir = Booking::with(['siswa', 'kelas'])
            ->where('status', 'hadir')
            ->orderBy('jam_booking', 'asc')
            ->get();

        // Booking yang sudah selesai
        $selesai = Booking::with(['siswa', 'kelas'])
            ->where('status', 'selesai')
            ->orderBy('jam_booking', 'desc')
            ->limit(20)
            ->get();

        // Per-kelas data dengan queue, hadir, selesai
        $kelas = Kelas::all()->map(function ($k) use ($bookings, $hadir, $selesai) {
            return [
                'id' => $k->id,
                'nama' => $k->nama,
                'kode_kelas' => $k->kode_kelas,
                'ruangan' => $k->ruangan,
                'queue' => $bookings->where('kelas_id', $k->id)->values(),
                'count' => $bookings->where('kelas_id', $k->id)->count(),
                'hadir' => $hadir->where('kelas_id', $k->id)->values(),
                'hadir_count' => $hadir->where('kelas_id', $k->id)->count(),
                'selesai' => $selesai->where('kelas_id', $k->id)->values(),
                'selesai_count' => $selesai->where('kelas_id', $k->id)->count(),
            ];
        });

        return response()->json([
            'bookings' => $bookings,
            'hadir' => $hadir,
            'selesai' => $selesai,
            'kelas' => $kelas,
        ])
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }
}
