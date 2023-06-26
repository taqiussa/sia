<?php

use App\Http\Controllers\InputSosialController;
use Illuminate\Support\Facades\Route;

// Group Bendahara dan Kepala Sekolah
Route::middleware([
    'auth', 'role:Guru|Kepala Sekolah'
])->group(function () {

    // Route Input Sosial
    Route::controller(InputSosialController::class)->group(function () {
        Route::get('input-sosial', 'index')->name('input-sosial');
        Route::post('input-sosial', 'simpan')->name('input-sosial.simpan');
        Route::post('input-sosial/nihil', 'nihil')->name('input-sosial.nihil');
    });
});
