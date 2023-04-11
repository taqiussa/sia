<?php

use App\Http\Controllers\AturKategoriPemasukanController;
use App\Http\Controllers\AturKategoriPengeluaranController;
use App\Http\Controllers\AturWajibBayarController;
use App\Http\Controllers\GetDataBendaharaController;
use App\Http\Controllers\InputPembayaranSiswaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return inertia('Auth/Login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Group Data
Route::middleware('auth')->group(function () {

    // Route Get Data Bendahara
    Route::controller(GetDataBendaharaController::class)->group(function () {
        Route::post('get-wajib-bayar', 'get_wajib_bayar')->name('get-wajib-bayar');
    });
});

// Group Bendahara dan Kepala Sekolah
Route::middleware([
    'auth', 'role:Bendahara|Kepala Sekolah'
])->group(function () {

    // Route Atur Wajib Bayar
    Route::controller(AturWajibBayarController::class)->group(function () {
        Route::get('atur-wajib-bayar', 'index')->name('atur-wajib-bayar');
        Route::post('atur-wajib-bayar', 'simpan')->name('atur-wajib-bayar.simpan');
        Route::delete('atur-wajib-bayar', 'hapus')->name('atur-wajib-bayar.hapus');
    });

    // Route Atur Kategori Pemasukan
    Route::controller(AturKategoriPemasukanController::class)->group(function () {
        Route::get('atur-kategori-pemasukan', 'index')->name('atur-kategori-pemasukan');
        Route::post('atur-kategori-pemasukan', 'simpan')->name('atur-kategori-pemasukan.simpan');
        Route::delete('atur-kategori-pemasukan', 'hapus')->name('atur-kategori-pemasukan.hapus');
    });

    // Route Atur Kategori Pengeluaran
    Route::controller(AturKategoriPengeluaranController::class)->group(function () {
        Route::get('atur-kategori-pengeluaran', 'index')->name('atur-kategori-pengeluaran');
        Route::post('atur-kategori-pengeluaran', 'simpan')->name('atur-kategori-pengeluaran.simpan');
        Route::delete('atur-kategori-pengeluaran', 'hapus')->name('atur-kategori-pengeluaran.hapus');
    });

    // Route Input Pembayaran Siswa
    Route::controller(InputPembayaranSiswaController::class)->group(function () {
        Route::get('input-pembayaran-siswa' , 'index')->name('input-pembayaran-siswa');
        Route::post('input-pembayaran-siswa', 'simpan')->name('input-pembayaran-siswa.simpan');
        Route::delete('input-pembayaran-siswa', 'hapus')->name('input-pembayaran-siswa.hapus');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
