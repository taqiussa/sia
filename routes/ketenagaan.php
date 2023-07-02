<?php

use App\Http\Controllers\AturKhususPulangController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListBadalController;
use App\Http\Controllers\AturPulangAwalController;
use App\Http\Controllers\AturPulangSpesialController;
use App\Http\Controllers\RekapJamKosongController;
use App\Http\Controllers\JadwalJamKosongController;
use App\Http\Controllers\PermintaanBadalController;
use App\Http\Controllers\ProsesTransportController;
use App\Http\Controllers\RekapHarianAbsensiKaryawanController;
use App\Http\Controllers\RekapTransportPerKaryawanController;
use App\Http\Controllers\RekapTransportTotalController;

// Group Ketenagaan
Route::middleware([
    'auth', 'role:Ketenagaan|Bendahara|Kepala Sekolah'
])->group(function () {


    // Route Atur Pulang Awal
    Route::controller(AturPulangAwalController::class)->group(function () {
        Route::get('atur-pulang-awal', 'index')->name('atur-pulang-awal');
        Route::post('atur-pulang-awal', 'simpan')->name('atur-pulang-awal.simpan');
        Route::delete('atur-pulang-awal', 'hapus')->name('atur-pulang-awal.hapus');
    });

    // Route Atur Pulang Khusus
    Route::controller(AturKhususPulangController::class)->group(function () {
        Route::get('atur-khusus-pulang', 'index')->name('atur-khusus-pulang');
        Route::post('atur-khusus-pulang', 'simpan')->name('atur-khusus-pulang.simpan');
        Route::delete('atur-khusus-pulang', 'hapus')->name('atur-khusus-pulang.hapus');
    });

    // Route Atur Pulang Spesial
    Route::controller(AturPulangSpesialController::class)->group(function () {
        Route::get('atur-pulang-spesial', 'index')->name('atur-pulang-spesial');
        Route::post('atur-pulang-spesial', 'simpan')->name('atur-pulang-spesial.simpan');
        Route::delete('atur-pulang-spesial', 'hapus')->name('atur-khusus-pulang.hapus');
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

    // Route Proses Transport
    Route::controller(ProsesTransportController::class)->group(function () {
        Route::get('proses-transport', 'index')->name('proses-transport');
        Route::post('proses-transport', 'simpan')->name('proses-transport.simpan');
        Route::delete('proses-transport', 'hapus')->name('proses-transport.hapus');
    });

    // Route Rekap Harian Absensi Karyawan
    Route::controller(RekapHarianAbsensiKaryawanController::class)->group(function () {
        Route::get('rekap-harian-absensi-karyawan', 'index')->name('rekap-harian-absensi-karyawan');
        Route::delete('rekap-harian-absensi-karyawan', 'hapus')->name('rekap-harian-absensi-karyawan.hapus');
    });

    // Route Rekap Jam Kosong
    Route::get('rekap-jam-kosong', RekapJamKosongController::class)->name('rekap-jam-kosong');

    // Route Rekap Transport Per Karyawan
    Route::get('rekap-transport-per-karyawan', RekapTransportPerKaryawanController::class)->name('rekap-transport-per-karyawan');

    // Route Rekap Transport Total
    Route::get('rekap-transport-total', RekapTransportTotalController::class)->name('rekap-transport-total');
});
