<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Kelas;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $kelasStat = Kelas::with(['waliKelas', 'siswas.bookings'])->get()
            ->map(function ($kelas) {
                $siswaIds = $kelas->siswas->pluck('id');
 
                $total  = Booking::whereIn('siswa_id', $siswaIds)->count();
                $hadir  = Booking::whereIn('siswa_id', $siswaIds)->count();
                $belum  = $total - $hadir;
 
                return [
                    'nama'  => $kelas->nama,
                    'kode'  => $kelas->kode_kelas,
                    'wali'  => $kelas->waliKelas->nama ?? '-',
                    'total' => $total,
                    'hadir' => $hadir,
                    'belum' => $belum,
                ];
            });
 
        // ── Tabel booking dengan filter & search ─────────────────────────
        $query = Booking::with(['siswa', 'kelas'])
            ->latest();
 
        // Filter status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
 
        // Search nama orang tua
        if ($request->filled('search')) {
            $query->where('nama_orangtua', 'like', '%' . $request->search . '%');
        }
 
        $bookings = $query->paginate(10);
 
        return view('admin.index', compact('kelasStat', 'bookings'));
    }

    public function confirmBooking(Booking $booking)
    {
        $booking->update(['status' => 'hadir']);
        return back()->with('success', 'Booking berhasil dikonfirmasi (Tamu Hadir).');
    }

    public function destroyBooking(Booking $booking)
    {
        $booking->delete();
        return back()->with('success', 'Booking berhasil dihapus.');
    }
}
