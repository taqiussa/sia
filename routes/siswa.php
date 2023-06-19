<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataSkorController;
use App\Http\Controllers\DataNilaiController;
use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\DataBimbinganController;
use App\Http\Controllers\AlquranBilghoibController;
use App\Http\Controllers\AlquranBinnadzorController;

// Group Siswa
Route::middleware([
    'auth', 'role:Kurikulum'
])->group(function () {
    // Sidebar Siswa

    // Route Administrasi
    Route::get('administrasi', AdministrasiController::class)->name('administrasi');

    // Route Al Qur'an Bilghoib
    Route::get('alquran-bilghoib', AlquranBilghoibController::class)->name('alquran-bilghoib');

    // Route Al Qur'an Binnadzor
    Route::get('alquran-binnadzor', AlquranBinnadzorController::class)->name('alquran-binnadzor');

    // Route Data Bimbingan
    Route::controller(DataBimbinganController::class)->group(function () {
        Route::get('data-bimbingan', 'index')->name('data-bimbingan');
        Route::get('data-bimbingan/detail', 'detail')->name('data-bimbingan.detail');
    });

    // Route Data Nilai
    Route::get('data-nilai', DataNilaiController::class)->name('data-nilai');

    // Route Data Skor
    Route::get('data-skor', DataSkorController::class)->name('data-skor');

    // End Sidebar Siswa

});
