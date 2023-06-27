<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CekKdController;
use App\Http\Controllers\AturNamaElemenController;
use App\Http\Controllers\AturNamaProyekController;
use App\Http\Controllers\AturNamaDimensiController;
use App\Http\Controllers\AturNamaSubElemenController;
use App\Http\Controllers\CekPenilaianKelasController;
use App\Http\Controllers\AturPenilaianProyekController;
use App\Http\Controllers\CekPenilaianSikapController;

// Group Kurikulum
Route::middleware([
    'auth', 'role:Kurikulum'
])->group(function () {

    // Route Atur Nama Dimensi
    Route::controller(AturNamaDimensiController::class)->group(function () {
        Route::get('atur-nama-dimensi', 'index')->name('atur-nama-dimensi');
        Route::post('atur-nama-dimensi', 'simpan')->name('atur-nama-dimensi.simpan');
        Route::delete('atur-nama-dimensi', 'hapus')->name('atur-nama-dimensi.hapus');
    });

    // Route Atur Nama Elemen
    Route::controller(AturNamaElemenController::class)->group(function () {
        Route::get('atur-nama-elemen', 'index')->name('atur-nama-elemen');
        Route::post('atur-nama-elemen', 'simpan')->name('atur-nama-elemen.simpan');
        Route::delete('atur-nama-elemen', 'hapus')->name('atur-nama-elemen.hapus');
    });

    // Route Atur Nama Proyek
    Route::controller(AturNamaProyekController::class)->group(function () {
        Route::get('atur-nama-proyek', 'index')->name('atur-nama-proyek');
        Route::post('atur-nama-proyek', 'simpan')->name('atur-nama-proyek.simpan');
        Route::delete('atur-nama-proyek', 'hapus')->name('atur-nama-proyek.hapus');
    });

    // Route Atur Nama Sub Elemen
    Route::controller(AturNamaSubElemenController::class)->group(function () {
        Route::get('atur-nama-sub-elemen', 'index')->name('atur-nama-sub-elemen');
        Route::post('atur-nama-sub-elemen', 'simpan')->name('atur-nama-sub-elemen.simpan');
        Route::delete('atur-nama-sub-elemen', 'hapus')->name('atur-nama-sub-elemen.hapus');
    });

    // Route Atur Penilaian Proyek
    Route::controller(AturPenilaianProyekController::class)->group(function () {
        Route::get('atur-penilaian-proyek', 'index')->name('atur-penilaian-proyek');
        Route::post('atur-penilaian-proyek', 'simpan')->name('atur-penilaian-proyek.simpan');
        Route::delete('atur-penilaian-proyek', 'hapus')->name('atur-penilaian-proyek.hapus');
    });

    // Route Cek Kd
    Route::get('cek-kd', CekKdController::class)->name('cek-kd');

    // Route Cek Penilaian
    Route::get('cek-penilaian-kelas', CekPenilaianKelasController::class)->name('cek-penilaian-kelas');
    
    // Route Cek Penilaian Sikap
    Route::get('cek-penilaian-sikap', CekPenilaianSikapController::class)->name('cek-penilaian-sikap');
});
