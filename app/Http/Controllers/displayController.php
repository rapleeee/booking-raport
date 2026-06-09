<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class displayController extends Controller
{
    public function index()
    {
        return view('display.index');
    }

    public function data()
    {
        // Get all active bookings that are marked as 'dipanggil' today
        $bookings = Booking::with(['siswa', 'kelas'])
            // ->where('tanggal_booking', date('Y-m-d')) // Di-comment agar bisa test simulasi beda hari
            ->where('status', 'dipanggil')
            ->orderBy('jam_booking', 'asc')
            ->get();

        return response()->json($bookings)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
    }
}
