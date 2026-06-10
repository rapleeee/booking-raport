<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\ScheduleDate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class bookingController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function class()
    {
        $kelas = Kelas::with('waliKelas')->get();
        return view('booking.class', compact('kelas'));
    }

    public function postClass(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'wali_kelas_id' => 'required',
        ]);

        session([
            'booking.kelas_id' => $request->kelas_id,
            'booking.wali_kelas_id' => $request->wali_kelas_id,
        ]);

        return redirect()->route('booking.create');
    }

    public function create()
    {
        $kelasId = session('booking.kelas_id');
        if (!$kelasId) return redirect()->route('booking.class');

        // Only show students belonging to the selected class
        $siswas = Siswa::where('kelas_id', $kelasId)->get();
        
        // Active dates
        $scheduleDates = ScheduleDate::where('is_active', true)->orderBy('tanggal', 'asc')->get();

        return view('booking.index', compact('siswas', 'scheduleDates'));
    }

    public function getSlots(Request $request)
    {
        $tanggal = $request->query('tanggal');
        $kelasId = session('booking.kelas_id');

        if (!$tanggal || !$kelasId) {
            return response()->json([]);
        }

        $schedule = ScheduleDate::where('tanggal', $tanggal)->where('is_active', true)->first();
        if (!$schedule || !$schedule->time_slots) {
            return response()->json([]);
        }

        $allSlots = $schedule->time_slots;

        // Get booked slots for this class on this date
        $bookedSlots = Booking::where('tanggal_booking', $tanggal)
                              ->where('kelas_id', $kelasId)
                              ->pluck('jam_booking')
                              ->toArray();

        // Remove seconds if present in DB to match
        $bookedSlots = array_map(function($time) {
            return date('H:i:s', strtotime($time));
        }, $bookedSlots);

        $formattedAllSlots = array_map(function($time) {
            return date('H:i:s', strtotime($time));
        }, $allSlots);

        $slotsData = [];
        foreach ($formattedAllSlots as $slot) {
            $slotsData[] = [
                'time' => $slot,
                'is_booked' => in_array($slot, $bookedSlots)
            ];
        }

        return response()->json($slotsData);
    }

    public function postCreate(Request $request)
    {
        $request->validate([
            'nama_orangtua' => 'required|string|max:255',
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal_booking' => 'required|date',
            'jam_booking' => 'required',
        ]);

        session([
            'booking.data' => [
                'nama_orangtua' => $request->nama_orangtua,
                'siswa_id' => $request->siswa_id,
                'tanggal_booking' => $request->tanggal_booking,
                'jam_booking' => $request->jam_booking,
            ]
        ]);

        return redirect()->route('booking.confirm');
    }

    public function confirm()
    {
        $data = session('booking.data');
        $kelasId = session('booking.kelas_id');

        if (!$data || !$kelasId) return redirect()->route('booking.class');

        $siswa = Siswa::find($data['siswa_id']);
        $kelas = Kelas::find($kelasId);

        return view('booking.confirm', compact('data', 'siswa', 'kelas'));
    }

    public function store(Request $request)
    {
        $data = session('booking.data');
        $kelasId = session('booking.kelas_id');

        if (!$data || !$kelasId) return redirect()->route('booking.class');

        // Verify slot is still available
        $exists = Booking::where('tanggal_booking', $data['tanggal_booking'])
                         ->where('jam_booking', date('H:i:s', strtotime($data['jam_booking'])))
                         ->where('kelas_id', $kelasId)
                         ->exists();

        if ($exists) {
            return redirect()->route('booking.create')->withErrors(['jam_booking' => 'Slot waktu sudah diambil orang lain, silakan pilih waktu lain.']);
        }

        $booking = Booking::create([
            'nama_orangtua' => $data['nama_orangtua'],
            'kelas_id' => $kelasId,
            'siswa_id' => $data['siswa_id'],
            'tanggal_booking' => $data['tanggal_booking'],
            'jam_booking' => $data['jam_booking'],
            'unique_code' => strtoupper(Str::random(8)),
            'status' => 'booked',
        ]);

        session()->forget(['booking.data', 'booking.kelas_id', 'booking.wali_kelas_id']);

        return redirect()->route('booking.ticket', $booking->id);
    }

    public function ticket(Booking $booking)
    {
        $booking->load(['siswa', 'kelas']);
        return view('booking.ticket', compact('booking'));
    }
}
