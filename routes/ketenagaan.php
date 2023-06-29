<?php

use App\Http\Controllers\AturKhususPulangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListBadalController;
use App\Http\Controllers\AturPulangAwalController;
use App\Http\Controllers\RekapJamKosongController;
use App\Http\Controllers\JadwalJamKosongController;
use App\Http\Controllers\PermintaanBadalController;
use App\Http\Controllers\RekapHarianAbsensiKaryawanController;

// Group Ketenagaan
Route::middleware([
    'auth', 'role:Ketenagaan'
])->group(function () {

    // Route Atur Khusus Pulang
    Route::controller(AturKhususPulangController::class)->group(function() {
        Route::get('atur-khusus-pulang', 'index')->name('atur-khusus-pulang');
        Route::post('atur-khusus-pulang', 'simpan')->name('atur-khusus-pulang.simpan');
        Route::delete('atur-khusus-pulang', 'hapus')->name('atur-khusus-pulang.hapus');
    });

    // Route Atur Pulang Awal
    Route::controller(AturPulangAwalController::class)->group(function () {
        Route::get('atur-pulang-awal', 'index')->name('atur-pulang-awal');
        Route::post('atur-pulang-awal', 'simpan')->name('atur-pulang-awal.simpan');
        Route::delete('atur-pulang-awal', 'hapus')->name('atur-pulang-awal.hapus');
    });

    // Route Jadwal Jam Kosong
    Route::controller(JadwalJamKosongController::class)->group(function () {
        Route::get('jadwal-jam-kosong', 'index')->name('jadwal-jam-kosong');
        Route::post('jadwal-jam-kosong', 'simpan')->name('jadwal-jam-kosong.simpan');
        Route::delete('jadwal-jam-kosong', 'hapus')->name('jadwal-jam-kosong.hapus');
    });

    // Route List Badal
    Route::controller(ListBadalController::class)->group(function () {
        Route::get('list-badal', 'index')->name('list-badal');
    });

    // Route Permintaan Badal
    Route::controller(PermintaanBadalController::class)->group(function () {
        Route::get('permintaan-badal', 'index')->name('permintaan-badal');
        Route::post('permintaan-badal', 'simpan')->name('permintaan-badal.simpan');
    });

    // Route Rekap Harian Absensi Karyawan
    Route::controller(RekapHarianAbsensiKaryawanController::class)->group(function () {
        Route::get('rekap-harian-absensi-karyawan', 'index')->name('rekap-harian-absensi-karyawan');
        Route::delete('rekap-harian-absensi-karyawan', 'hapus')->name('rekap-harian-absensi-karyawan.hapus');
    });

    // Route Rekap Jam Kosong
    Route::get('rekap-jam-kosong', RekapJamKosongController::class)->name('rekap-jam-kosong');
});
