<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\SlipGajiController;
use App\Http\Controllers\GetDataBkController;
use App\Http\Controllers\GetDataKdController;
use App\Http\Controllers\GetDataGuruController;
use App\Http\Controllers\GetDataSkorController;
use App\Http\Controllers\GetDataSiswaController;
use App\Http\Controllers\BendaharaPrintController;
use App\Http\Controllers\GetDataAbsensiController;
use App\Http\Controllers\GetDataBendaharaController;
use App\Http\Controllers\GetDataPenilaianController;
use App\Http\Controllers\GetDataKetenagaanController;
use App\Http\Controllers\GetDataAbsensiKaryawanController;
use App\Http\Controllers\GetDataPenilaianKaryawanController;
use App\Http\Controllers\RaporTendikController;
use App\Http\Controllers\RekapAbsensiGuruKaryawanController;
use App\Http\Controllers\RekapTransportController;

// Group Data
Route::middleware('auth')->group(function () {
    // Menu Guru & Karyawan 

    // Route Rapor Tendik
    Route::get('rapor-tendik', RaporTendikController::class)->name('rapor-tendik');

    //Route Rekap Absensi Guru & Karyawan
    Route::get('rekap-absensi-karyawan', RekapAbsensiGuruKaryawanController::class)->name('rekap-absensi-karyawan');

    // Route Rekap Transport
    Route::get('rekap-transport', RekapTransportController::class)->name('rekap-transport');

    // Route Slip Gaji
    Route::get('slip-gaji', SlipGajiController::class)->name('slip-gaji');

    //End Menu Guru & Karyawan

    // Get Data

    // Route Bendahara Print Controller
    Route::controller(BendaharaPrintController::class)->group(function () {
        Route::get('kwitansi', 'kwitansi')->name('kwitansi');
        Route::get('kas-bulanan-print', 'kas_bulanan_print')->name('kas-bulanan-print');
        Route::get('kas-tahunan-print', 'kas_tahunan_print')->name('kas-tahunan-print');
        Route::get('rekap-harian-pemasukan-detail', 'rekap_harian_pemasukan_detail')->name('rekap-harian-pemasukan-detail');
        Route::get('rekap-harian-pemasukan-simple', 'rekap_harian_pemasukan_simple')->name('rekap-harian-pemasukan-simple');
        Route::get('rekap-harian-pengeluaran-detail', 'rekap_harian_pengeluaran_detail')->name('rekap-harian-pengeluaran-detail');
        Route::get('rekap-harian-pengeluaran-simple', 'rekap_harian_pengeluaran_simple')->name('rekap-harian-pengeluaran-simple');
        Route::get('rekap-per-siswa-print', 'rekap_per_siswa_print')->name('rekap-per-siswa-print');
        Route::get('rekap-tahunan-pemasukan-detail', 'rekap_tahunan_pemasukan_detail')->name('rekap-tahunan-pemasukan-detail');
        Route::get('rekap-tahunan-pemasukan-simple', 'rekap_tahunan_pemasukan_simple')->name('rekap-tahunan-pemasukan-simple');
        Route::get('rekap-tahunan-pengeluaran-detail', 'rekap_tahunan_pengeluaran_detail')->name('rekap-tahunan-pengeluaran-detail');
        Route::get('rekap-tahunan-pengeluaran-simple', 'rekap_tahunan_pengeluaran_simple')->name('rekap-tahunan-pengeluaran-simple');
        Route::get('tagihan-per-kelas-print', 'tagihan_per_kelas_print')->name('tagihan-per-kelas-print');
    });

    // Route Get Data
    Route::controller(GetDataController::class)->group(function () {
        Route::post('get-all-siswa', 'get_all_siswa')->name('get-all-siswa');
        Route::post('get-all-siswa-belum-ekstra', 'get_all_siswa_belum_ekstra')->name('get-all-siswa-belum-ekstra');
        Route::post('get-all-siswa-ekstra', 'get_all_siswa_ekstra')->name('get-all-siswa-ekstra');
        Route::post('get-all-siswa-with-biodata', 'get_all_siswa_with_biodata')->name('get-all-siswa-with-biodata');
        Route::post('get-list-ekstra', 'get_list_ekstra')->name('get-list-ekstra');
        Route::post('get-prestasi', 'get_prestasi')->name('get-prestasi');
        Route::post('get-siswa', 'get_siswa')->name('get-siswa');
        Route::post('get-siswa-ekstra', 'get_siswa_ekstra')->name('get-siswa-ekstra');
        Route::post('get-siswa-with-biodata', 'get_siswa_with_biodata')->name('get-siswa-with-biodata');
        Route::post('get-siswa-with-catatan', 'get_siswa_with_catatan')->name('get-siswa-with-catatan');
        Route::post('get-siswa-with-skor', 'get_siswa_with_skor')->name('get-siswa-with-skor');
    });

    // Route Get Data Absensi
    Route::controller(GetDataAbsensiController::class)->group(function () {
        Route::post('get-absensi-ekstrakurikuler', 'get_absensi_ekstrakurikuler')->name('get-absensi-ekstrakurikuler');
        Route::post('get-absensi-kelas', 'get_absensi_kelas')->name('get-absensi-kelas');
        Route::post('get-absensi-siswa', 'get_absensi_siswa')->name('get-absensi-siswa');
        Route::post('get-absensi-ujian', 'get_absensi_ujian')->name('get-absensi-ujian');
        Route::post('get-info-absensi', 'get_info_absensi')->name('get-info-absensi');
        Route::post('get-siswa-with-alpha', 'get_siswa_with_alpha')->name('get-siswa-with-alpha');
    });

    // Route Get Data Absensi Guru dan Karyawan
    Route::controller(GetDataAbsensiKaryawanController::class)->group(function () {
        Route::post('get-list-aturan-pulang-awal', 'get_list_aturan_pulang_awal')->name('get-list-aturan-pulang-awal');
        Route::post('get-rekap-absensi-karyawan', 'get_rekap_absensi_karyawan')->name('get-rekap-absensi-karyawan');
        Route::post('get-absensi-harian-karyawan', 'get_absensi_harian_karyawan')->name('get-absensi-harian-karyawan');
    });

    // Route Get Data Bendahara
    Route::controller(GetDataBendaharaController::class)->group(function () {
        Route::post('get-kas-bulanan', 'get_kas_bulanan')->name('get-kas-bulanan');
        Route::post('get-kas-tahunan', 'get_kas_tahunan')->name('get-kas-tahunan');
        Route::post('get-pemasukan', 'get_pemasukan')->name('get-pemasukan');
        Route::post('get-pemasukan-harian', 'get_pemasukan_harian')->name('get-pemasukan-harian');
        Route::post('get-pemasukan-tahunan', 'get_pemasukan_tahunan')->name('get-pemasukan-tahunan');
        Route::post('get-pembayaran', 'get_pembayaran')->name('get-pembayaran');
        Route::post('get-pembayaran-custom', 'get_pembayaran_custom')->name('get-pembayaran-custom');
        Route::post('get-pembayaran-siswa', 'get_pembayaran_siswa')->name('get-pembayaran-siswa');
        Route::post('get-pengeluaran', 'get_pengeluaran')->name('get-pengeluaran');
        Route::post('get-pengeluaran-tahunan', 'get_pengeluaran_tahunan')->name('get-pengeluaran-tahunan');
        Route::post('get-penggajian', 'get_penggajian')->name('get-penggajian');
        Route::post('get-pengeluaran-harian', 'get_pengeluaran_harian')->name('get-pengeluaran-harian');
        Route::post('get-wajib-bayar', 'get_wajib_bayar')->name('get-wajib-bayar');
    });

    // Route Get Data BK
    Route::controller(GetDataBkController::class)->group(function () {
        Route::post('get-rekap-bimbingan', 'get_rekap_bimbingan')->name('get-rekap-bimbingan');
        Route::post('get-rekap-kehadiran', 'get_rekap_kehadiran')->name('get-rekap-kehadiran');
        Route::post('get-rekap-skor', 'get_rekap_skor')->name('get-rekap-skor');
    });

    // Route Get Data Guru
    Route::controller(GetDataGuruController::class)->group(function () {
        Route::post('get-aturan-per-proyek', 'get_aturan_per_proyek')->name('get-aturan-per-proyek');
        Route::post('get-aturan-per-sub-elemen', 'get_aturan_per_sub_elemen')->name('get-aturan-per-sub-elemen');
        Route::post('get-kelas-wali-kelas', 'get_kelas_wali_kelas')->name('get-kelas-wali-kelas');
        Route::post('get-list-aturan-proyek', 'get_list_aturan_proyek')->name('get-list-aturan-proyek');
        Route::post('get-list-dimensi', 'get_list_dimensi')->name('get-list-dimensi');
        Route::post('get-list-elemen', 'get_list_elemen')->name('get-list-elemen');
        Route::post('get-list-jenis', 'get_list_jenis')->name('get-list-jenis');
        Route::post('get-list-jenis-per-tingkat', 'get_list_jenis_per_tingkat')->name('get-list-jenis-per-tingkat');
        Route::post('get-list-jenis-sikap', 'get_list_jenis_sikap')->name('get-list-jenis-sikap');
        Route::post('get-list-kategori', 'get_list_kategori')->name('get-list-kategori');
        Route::post('get-list-kategori-per-tingkat', 'get_list_kategori_per_tingkat')->name('get-list-kategori-per-tingkat');
        Route::post('get-list-kd', 'get_list_kd')->name('get-list-kd');
        Route::post('get-list-kelas-guru', 'get_list_kelas_guru')->name('get-list-kelas-guru');
        Route::post('get-list-sub-elemen', 'get_list_sub_elemen')->name('get-list-sub-elemen');
        Route::post('get-list-tugas', 'get_list_tugas')->name('get-list-tugas');
        Route::post('get-slip-gaji', 'get_slip_gaji')->name('get-slip-gaji');
    });

    // Route Get Data KD 
    Route::controller(GetDataKdController::class)->group(function () {
        Route::post('get-kd-per-tingkat', 'get_kd_per_tingkat')->name('get-kd-per-tingkat');
    });

    // Route Get Data Ketenagaan
    Route::controller(GetDataKetenagaanController::class)->group(function () {
        Route::post('get-aturan-khusus-pulang', 'get_aturan_khusus_pulang')->name('get-aturan-khusus-pulang');
        Route::post('get-guru-izin', 'get_guru_izin')->name('get-guru-izin');
        Route::post('get-guru-kosong', 'get_guru_kosong')->name('get-guru-kosong');
        Route::post('get-guru-sudah-badal', 'get_guru_sudah_badal')->name('get-guru-sudah-badal');
        Route::post('get-list-aturan-pulang-spesial', 'get_list_aturan_pulang_spesial')->name('get-list-aturan-pulang-spesial');
        Route::post('get-list-jadwal-kosong', 'get_list_jadwal_kosong')->name('get-list-jadwal-kosong');
        Route::post('get-permintaan-badal', 'get_permintaan_badal')->name('get-permintaan-badal');
        Route::post('get-rekap-jam-kosong', 'get_rekap_jam_kosong')->name('get-rekap-jam-kosong');
        Route::post('get-rekap-transport', 'get_rekap_transport')->name('get-rekap-transport');
        Route::post('get-rekap-transport-per-karyawan', 'get_rekap_transport_per_karyawan')->name('get-rekap-transport-per-karyawan');
        Route::post('get-rekap-transport-total', 'get_rekap_transport_total')->name('get-rekap-transport-total');
    });

    // Route Get Data Penilaian
    Route::controller(GetDataPenilaianController::class)->group(function () {
        Route::post('get-list-jenis-alquran-with-nilai-siswa', 'get_list_jenis_alquran_with_nilai_siswa')->name('get-list-jenis-alquran-with-nilai-siswa');
        Route::post('get-penilaian-per-kelas', 'get_penilaian_per_kelas')->name('get-penilaian-per-kelas');
        Route::post('get-penilaian-sikap-per-kelas', 'get_penilaian_sikap_per_kelas')->name('get-penilaian-sikap-per-kelas');
        Route::post('get-siswa-ekstra-with-nilai', 'get_siswa_ekstra_with_nilai')->name('get-siswa-ekstra-with-nilai');
        Route::post('get-siswa-pengayaan', 'get_siswa_pengayaan')->name('get-siswa-pengayaan');
        Route::post('get-siswa-remidi', 'get_siswa_remidi')->name('get-siswa-remidi');
        Route::post('get-siswa-with-analisis-nilai', 'get_siswa_with_analisis_nilai')->name('get-siswa-with-analisis-nilai');
        Route::post('get-siswa-with-nilai', 'get_siswa_with_nilai')->name('get-siswa-with-nilai');
        Route::post('get-siswa-with-nilai-alquran', 'get_siswa_with_nilai_alquran')->name('get-siswa-with-nilai-alquran');
        Route::post('get-siswa-with-nilai-proyek', 'get_siswa_with_nilai_proyek')->name('get-siswa-with-nilai-proyek');
        Route::post('get-siswa-with-nilai-sikap', 'get_siswa_with_nilai_sikap')->name('get-siswa-with-nilai-sikap');
    });

    // Route Get Data Penilaian Karyawan
    Route::controller(GetDataPenilaianKaryawanController::class)->group(function () {
        Route::post('get-absensi-ibadah', 'get_absensi_ibadah')->name('get-absensi-ibadah');
        Route::post('get-absensi-ibadahs', 'get_absensi_ibadahs')->name('get-absensi-ibadahs');
        Route::post('get-absensi-sosial', 'get_absensi_sosial')->name('get-absensi-sosial');
        Route::post('get-absensi-sosials', 'get_absensi_sosials')->name('get-absensi-sosials');
        Route::post('get-karyawan-with-nilai', 'get_karyawan_with_nilai')->name('get-karyawan-with-nilai');
        Route::post('get-list-jenis-penilaian-karyawan', 'get_list_jenis_penilaian_karyawan')->name('get-list-jenis-penilaian-karyawan');
        Route::post('get-list-kategori-penilaian-karyawan', 'get_list_kategori_penilaian_karyawan')->name('get-list-kategori-penilaian-karyawan');
        Route::post('get-list-sosial', 'get_list_sosial')->name('get-list-sosial');
    });

    // Route Get Data Siswa
    Route::controller(GetDataSiswaController::class)->group(function () {
        Route::post('get-administrasi', 'get_administrasi')->name('get-administrasi');
        Route::post('get-data-bimbingan', 'get_data_bimbingan')->name('get-data-bimbingan');
        Route::post('get-data-nilai', 'get_data_nilai')->name('get-data-nilai');
        Route::post('get-data-skor', 'get_data_skor')->name('get-data-skor');
    });

    // Route Get Data Skor
    Route::controller(GetDataSkorController::class)->group(function () {
        // Route::post('get-siswa-with-skor', 'get_siswa_with_skor')->name('get-siswa-with-skor');
        Route::post('get-siswa-with-skor-wali-kelas', 'get_siswa_with_skor_wali_kelas')->name('get-siswa-with-skor-wali-kelas');
        Route::post('get-skor-kelas', 'get_skor_kelas')->name('get-skor-kelas');
        Route::post('get-skor-siswa', 'get_skor_siswa')->name('get-skor-siswa');
        Route::post('get-skor-siswa-per-guru', 'get_skor_siswa_per_guru')->name('get-skor-siswa-per-guru');
    });
});
