<?php

use App\Http\Controllers\InputIbadahController;
use App\Http\Controllers\InputSosialController;
use App\Http\Controllers\RekapIbadahController;
use App\Http\Controllers\RekapSosialController;
use App\Http\Controllers\TotalIbadahController;
use App\Http\Controllers\TotalSosialController;
use App\Http\Controllers\UploadNilaiKaryawanController;
use Illuminate\Support\Facades\Route;

// Group Bendahara dan Kepala Sekolah
Route::middleware([
    'auth', 'role:Guru|Kepala Sekolah|Tim Penilai'
])->group(function () {

    // Route Input Ibadah
    Route::controller(InputIbadahController::class)->group(function () {
        Route::get('input-ibadah', 'index')->name('input-ibadah');
        Route::post('input-ibadah', 'simpan')->name('input-ibadah.simpan');
        Route::post('input-ibadah/nihil', 'nihil')->name('input-ibadah.nihil');
    });

    // Route Input Sosial
    Route::controller(InputSosialController::class)->group(function () {
        Route::get('input-sosial', 'index')->name('input-sosial');
        Route::post('input-sosial', 'simpan')->name('input-sosial.simpan');
        Route::post('input-sosial/nihil', 'nihil')->name('input-sosial.nihil');
    });

    // Route Rekap Ibadah
    Route::get('rekap-ibadah', RekapIbadahController::class)->name('rekap-ibadah');

    // Route Rekap Sosial
    Route::get('rekap-sosial', RekapSosialController::class)->name('rekap-sosial');

    // Route Total Sosial
    Route::get('total-sosial', TotalSosialController::class)->name('total-sosial');

    // Route Total Sosial
    Route::get('total-ibadah', TotalIbadahController::class)->name('total-ibadah');

    // Route Upload Nilai Karyawan
    Route::controller(UploadNilaiKaryawanController::class)->group(function () {
        Route::get('upload-nilai-karyawan', 'index')->name('upload-nilai-karyawan');
        Route::get('upload-nilai-karyawan/download', 'download')->name('upload-nilai-karyawan.download');
        Route::post('upload-nilai-karyawan', 'upload')->name('upload-nilai-karyawan.upload');
    });
});
