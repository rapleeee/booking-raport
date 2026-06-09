<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'nama_orangtua',
        'kelas_id',       // ✅ tetap ada untuk referensi cepat
        'siswa_id',
        'tanggal_booking',
        'jam_booking',
        'unique_code',
        'status',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}