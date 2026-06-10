<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WaliKelas;
use App\Models\Booking;

class waliController extends Controller
{
    public function login()
    {
        return view('wali.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate(['pin' => 'required']);

        $wali = WaliKelas::where('pin', $request->pin)->first();

        if (!$wali) {
            return back()->withErrors(['pin' => 'PIN tidak valid.']);
        }

        session(['wali_id' => $wali->id]);
        return redirect()->route('wali.dashboard');
    }

    public function dashboard()
    {
        $waliId = session('wali_id');
        if (!$waliId) return redirect()->route('wali.login');

        $wali = WaliKelas::with('kelas')->find($waliId);
        
        $kelasIds = $wali->kelas->pluck('id');

        $bookings = Booking::with('siswa', 'kelas')
            ->whereIn('kelas_id', $kelasIds)
            // ->where('tanggal_booking', date('Y-m-d')) // Di-comment agar bisa test hari apa saja
            ->whereIn('status', ['hadir', 'dipanggil', 'selesai'])
            ->orderByRaw("FIELD(status, 'dipanggil', 'hadir', 'selesai')") 
            ->orderBy('jam_booking', 'asc')
            ->get();

        return view('wali.dashboard', compact('wali', 'bookings'));
    }

    public function panggil(Booking $booking)
    {
        // Cek apakah ada tamu lain yang sedang dilayani di kelas yang sama
        $isCallingOther = Booking::where('kelas_id', $booking->kelas_id)
            ->where('status', 'dipanggil')
            ->exists();
            
        if ($isCallingOther) {
            return back()->with('error', 'Selesaikan dulu tamu yang sedang dilayani saat ini!');
        }

        $booking->update(['status' => 'dipanggil']);
        return back()->with('success', 'Berhasil dipanggil! Silakan tunggu tamu masuk ke ruangan.');
    }

    public function selesai(Booking $booking)
    {
        $booking->update(['status' => 'selesai']);
        return back()->with('success', 'Selesai pembagian raport!');
    }
}
