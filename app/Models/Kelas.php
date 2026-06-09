<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'nama',
        'kode_kelas',
        'ruangan',
        'wali_kelas_id'  // ✅ ubah jadi snake_case lowercase
    ];

    public function waliKelas()  // ✅ camelCase
    {
        return $this->belongsTo(WaliKelas::class, 'wali_kelas_id');
    }

    public function siswas()  // ✅ tambah ini
    {
        return $this->hasMany(Siswa::class, 'kelas_id');
    }
}
