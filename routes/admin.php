<?php

use App\Http\Controllers\UploadSiswaController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:Admin'])->group(function() {

    // Route Upload Siswa Baru dan Lama
    Route::controller(UploadSiswaController::class)->group(function() {
        Route::get('upload-siswa', 'index')->name('upload-siswa');
        Route::post('upload-siswa-baru', 'siswa_baru')->name('upload-siswa-baru');
        Route::post('upload-siswa-lama', 'siswa_lama')->name('upload-siswa-lama');
    });

});