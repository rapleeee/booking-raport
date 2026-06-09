<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\bookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\waliController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('booking');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::patch('bookings/{booking}/confirm', [AdminController::class, 'confirmBooking'])->name('bookings.confirm');
    Route::delete('bookings/{booking}', [AdminController::class, 'destroyBooking'])->name('bookings.destroy');
    Route::resource('walikelas', \App\Http\Controllers\Admin\WaliKelasController::class);
    Route::resource('kelas', \App\Http\Controllers\Admin\KelasController::class);
    Route::get('siswa/template', [\App\Http\Controllers\Admin\SiswaController::class, 'downloadTemplate'])->name('siswa.template');
    Route::post('siswa/import/preview', [\App\Http\Controllers\Admin\SiswaController::class, 'importPreview'])->name('siswa.import.preview');
    Route::post('siswa/import/process', [\App\Http\Controllers\Admin\SiswaController::class, 'importProcess'])->name('siswa.import.process');
    Route::resource('siswa', \App\Http\Controllers\Admin\SiswaController::class);
    Route::resource('schedule_dates', \App\Http\Controllers\ScheduleDateController::class)->except(['create', 'show', 'edit', 'update']);
    Route::post('schedule_dates/{scheduleDate}/toggle', [\App\Http\Controllers\ScheduleDateController::class, 'toggle'])->name('schedule_dates.toggle');
    Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
});

// Display Live Queue
Route::get('/display', [\App\Http\Controllers\displayController::class, 'index'])->name('display.index');
Route::get('/display/data', [\App\Http\Controllers\displayController::class, 'data'])->name('display.data');

// Receptionist
Route::get('/receptionist', [\App\Http\Controllers\ReceptionistController::class, 'index'])->name('receptionist.index');
Route::post('/receptionist/scan', [\App\Http\Controllers\ReceptionistController::class, 'scan'])->name('receptionist.scan');

// Wali Kelas
Route::get('/wali', [\App\Http\Controllers\waliController::class, 'login'])->name('wali.login');
Route::post('/wali/login', [\App\Http\Controllers\waliController::class, 'postLogin'])->name('wali.postLogin');
Route::get('/wali/dashboard', [\App\Http\Controllers\waliController::class, 'dashboard'])->name('wali.dashboard');
Route::post('/wali/panggil/{booking}', [\App\Http\Controllers\waliController::class, 'panggil'])->name('wali.panggil');
Route::post('/wali/selesai/{booking}', [\App\Http\Controllers\waliController::class, 'selesai'])->name('wali.selesai');

Route::prefix('booking')->name('booking.')->group(function () {
    Route::get('/',         [BookingController::class, 'index'])->name('index');
    Route::get('/class',    [BookingController::class, 'class'])->name('class');
    Route::post('/class',   [BookingController::class, 'postClass'])->name('postClass');
    Route::get('/slots',    [BookingController::class, 'getSlots'])->name('slots');
    Route::get('/create',   [BookingController::class, 'create'])->name('create');
    Route::post('/create',  [BookingController::class, 'postCreate'])->name('postCreate');
    Route::get('/confirm',  [BookingController::class, 'confirm'])->name('confirm');
    Route::post('/confirm', [BookingController::class, 'store'])->name('store');
    Route::get('/ticket/{booking}',  [BookingController::class, 'ticket'])->name('ticket');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';