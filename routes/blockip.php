<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AbsensiKaryawanController;
use App\Http\Controllers\AbsensiKetenagaanController;

// Route Absensi Karyawan
Route::middleware(['auth', 'blockip'])->group(function () {

    Route::controller(AbsensiKaryawanController::class)->group(function () {
        Route::get('absensi-karyawan', 'index')->name('absensi-karyawan');
        Route::post('absensi-karyawan', 'simpan')->name('absensi-karyawan.simpan');
    });
});

// Route Absensi Karyawan
Route::middleware(['auth', 'blockip', 'role:Ketenagaan'])->group(function () {

    Route::controller(AbsensiKetenagaanController::class)->group(function () {
        Route::get('absensi-ketenagaan', 'index')->name('absensi-ketenagaan');
        Route::post('absensi-ketenagaan', 'simpan')->name('absensi-ketenagaan.simpan');
    });
});
