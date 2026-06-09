<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class ReceptionistController extends Controller
{
    public function index()
    {
        return view('receptionist.index');
    }

    public function scan(Request $request)
    {
        $code = $request->input('code');

        if (!$code) {
            return response()->json(['success' => false, 'message' => 'Kode unik tidak boleh kosong.'], 400);
        }

        $booking = Booking::with(['siswa', 'kelas'])->where('unique_code', $code)->first();

        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Tiket tidak ditemukan.'], 404);
        }

        if ($booking->status === 'hadir') {
            return response()->json(['success' => false, 'message' => 'Tamu sudah melakukan check-in sebelumnya.', 'booking' => $booking], 400);
        }
        
        if ($booking->status === 'selesai') {
            return response()->json(['success' => false, 'message' => 'Tiket ini sudah selesai digunakan.', 'booking' => $booking], 400);
        }

        $booking->update(['status' => 'hadir']);

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil!',
            'booking' => $booking
        ]);
    }
}
