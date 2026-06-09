<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Kelas;
use App\Models\ScheduleDate;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['siswa', 'kelas.waliKelas']);

        if ($request->filled('tanggal_booking')) {
            $query->where('tanggal_booking', $request->tanggal_booking);
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->orderBy('tanggal_booking', 'desc')
                          ->orderBy('jam_booking', 'asc')
                          ->get();

        $kelas = Kelas::orderBy('nama')->get();
        $dates = ScheduleDate::orderBy('tanggal', 'desc')->get();

        return view('admin.reports.index', compact('bookings', 'kelas', 'dates'));
    }
}
