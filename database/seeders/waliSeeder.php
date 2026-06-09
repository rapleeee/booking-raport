<?php

namespace Database\Seeders;

use App\Models\WaliKelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class waliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WaliKelas::create([
            'nama' => 'Budi',
            'pin' => '123456',
        ]);
    }
}
