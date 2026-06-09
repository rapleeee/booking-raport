<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_orangtua');
            $table->unsignedBigInteger('kelas_id')->constrained()->onDelete('cascade');  // ✅ tetap ada untuk referensi cepat
            $table->unsignedBigInteger('siswa_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_booking');
            $table->time('jam_booking');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
