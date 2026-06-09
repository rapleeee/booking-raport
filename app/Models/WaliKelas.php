<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    protected $fillable = [
        'nama',
        'pin'  // ✅ konvensi lowercase, di migration juga samakan
    ];

    public function kelas()  // ✅ tambah relasi balik (opsional tapi bagus)
    {
        return $this->hasMany(Kelas::class, 'wali_kelas_id');
    }
}