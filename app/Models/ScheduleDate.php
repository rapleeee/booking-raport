<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleDate extends Model
{
    protected $fillable = [
        'tanggal',
        'is_active',
        'time_slots',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'time_slots' => 'array',
    ];
}
