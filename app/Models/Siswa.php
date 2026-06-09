<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'nama',
        'kelas_id'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function bookings()  // ✅ tambah ini
    {
        return $this->hasMany(Booking::class, 'siswa_id');
    }
}