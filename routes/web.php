<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AbsensiEkstrakurikulerController;
use App\Http\Controllers\AbsensiUjianController;
use App\Http\Controllers\AturKategoriPemasukanController;
use App\Http\Controllers\AturKategoriPengeluaranController;
use App\Http\Controllers\AturWajibBayarController;
use App\Http\Controllers\BendaharaPrintController;
use App\Http\Controllers\DataPemasukanController;
use App\Http\Controllers\DataPembayaranSiswaController;
use App\Http\Controllers\DataPengeluaranController;
use App\Http\Controllers\DataSiswaEkstrakurikulerController;
use App\Http\Controllers\FormTugasController;
use App\Http\Controllers\GetAbsensiController;
use App\Http\Controllers\GetDataBendaharaController;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\InputDeskripsiEkstrakurikulerController;
use App\Http\Controllers\InputNilaiAlquranController;
use App\Http\Controllers\InputNilaiBilghoibPerKelasController;
use App\Http\Controllers\InputNilaiBinnadzorPerKelasController;
use App\Http\Controllers\InputNilaiEkstrakurikulerController;
use App\Http\Controllers\InputPemasukanController;
use App\Http\Controllers\InputPembayaranSiswaController;
use App\Http\Controllers\InputPengeluaranController;
use App\Http\Controllers\KasBulananController;
use App\Http\Controllers\KasTahunanController;
use App\Http\Controllers\PrintAbsensiEkstrakurikulerController;
use App\Http\Controllers\PrintAbsensiKelasController;
use App\Http\Controllers\PrintAbsensiUjianController;
use App\Http\Controllers\PrintNilaiAlquranController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekapHarianPemasukanController;
use App\Http\Controllers\RekapHarianPengeluaranController;
use App\Http\Controllers\RekapPenggajianController;
use App\Http\Controllers\RekapPerSiswaController;
use App\Http\Controllers\RekapTahunanPemasukanController;
use App\Http\Controllers\RekapTahunanPengeluaranController;
use App\Http\Controllers\SlipGajiController;
use App\Http\Controllers\TagihanPerKelasController;
use App\Http\Controllers\UploadAnalisisAlquranController;
use App\Http\Controllers\UploadPenggajianController;
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

    // Route Get Absensi
    Route::controller(GetAbsensiController::class)->group(function () {
        Route::post('get-absensi-ekstrakurikuler', 'get_absensi_ekstrakurikuler')->name('get-absensi-ekstrakurikuler');
        Route::post('get-absensi-siswa', 'get_absensi_siswa')->name('get-absensi-siswa');
        Route::post('get-absensi-ujian', 'get_absensi_ujian')->name('get-absensi-ujian');
        Route::post('get-info-absensi', 'get_info_absensi')->name('get-info-absensi');
    });

    // Route Get Data Bendahara
    Route::controller(GetDataBendaharaController::class)->group(function () {
        Route::post('get-pemasukan', 'get_pemasukan')->name('get-pemasukan');
        Route::post('get-pengeluaran', 'get_pengeluaran')->name('get-pengeluaran');
        Route::post('get-pembayaran', 'get_pembayaran')->name('get-pembayaran');
        Route::post('get-pembayaran-custom', 'get_pembayaran_custom')->name('get-pembayaran-custom');
        Route::post('get-pembayaran-siswa', 'get_pembayaran_siswa')->name('get-pembayaran-siswa');
        Route::post('get-wajib-bayar', 'get_wajib_bayar')->name('get-wajib-bayar');
    });

    // Route Get Data
    Route::controller(GetDataController::class)->group(function () {
        Route::post('get-all-siswa', 'get_all_siswa')->name('get-all-siswa');
        Route::post('get-siswa-ekstra-with-nilai', 'get_siswa_ekstra_with_nilai')->name('get-siswa-ekstra-with-nilai');
    });

    // Route Slip Gaji
    Route::get('slip-gaji', SlipGajiController::class)->name('slip-gaji');
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

    //Route Data Pemasukan
    Route::get('data-pemasukan', DataPemasukanController::class)->name('data-pemasukan');

    // Route Data Pembayaran Siswa
    Route::get('data-pembayaran-siswa', DataPembayaranSiswaController::class)->name('data-pembayaran-siswa');

    // Route Data Pengeluaran 
    Route::get('data-pengeluaran', DataPengeluaranController::class)->name('data-pengeluaran');

    // Route Input Pemasukan
    Route::controller(InputPemasukanController::class)->group(function () {
        Route::get('input-pemasukan', 'index')->name('input-pemasukan');
        Route::post('input-pemasukan', 'simpan')->name('input-pemasukan.simpan');
        Route::delete('input-pemasukan', 'hapus')->name('input-pemasukan.hapus');
    });

    // Route Input Pengeluaran
    Route::controller(InputPengeluaranController::class)->group(function () {
        Route::get('input-pengeluaran', 'index')->name('input-pengeluaran');
        Route::post('input-pengeluaran', 'simpan')->name('input-pengeluaran.simpan');
        Route::delete('input-pengeluaran', 'hapus')->name('input-pengeluaran.hapus');
    });

    // Route Input Pembayaran Siswa
    Route::controller(InputPembayaranSiswaController::class)->group(function () {
        Route::get('input-pembayaran-siswa', 'index')->name('input-pembayaran-siswa');
        Route::post('input-pembayaran-siswa', 'simpan')->name('input-pembayaran-siswa.simpan');
        Route::delete('input-pembayaran-siswa', 'hapus')->name('input-pembayaran-siswa.hapus');
    });

    // Route Kas Bulanan
    Route::get('kas-bulanan', KasBulananController::class)->name('kas-bulanan');

    // Route Kas Bulanan
    Route::get('kas-tahunan', KasTahunanController::class)->name('kas-tahunan');

    // Route Rekap Harian Pemasukan
    Route::controller(RekapHarianPemasukanController::class)->group(function () {
        Route::get('rekap-harian-pemasukan', 'index')->name('rekap-harian-pemasukan');
        Route::get('rekap-harian-pemasukan-download', 'download')->name('rekap-harian-pemasukan-download');
    });

    // Route Rekap Harian Pengeluaran
    Route::controller(RekapHarianPengeluaranController::class)->group(function () {
        Route::get('rekap-harian-pengeluaran', 'index')->name('rekap-harian-pengeluaran');
        Route::get('rekap-harian-pengeluaran-download', 'download')->name('rekap-harian-pengeluaran-download');
    });

    // Route Rekap Penggajian
    Route::get('rekap-penggajian', RekapPenggajianController::class)->name('rekap-penggajian');

    // Route Rekap Per Siswa
    Route::get('rekap-per-siswa', RekapPerSiswaController::class)->name('rekap-per-siswa');

    // Route Rekap Tahunan Pemasukan
    Route::get('rekap-tahunan-pemasukan', RekapTahunanPemasukanController::class)->name('rekap-tahunan-pemasukan');

    // Route Rekap Tahunan Pengeluaran
    Route::get('rekap-tahunan-pengeluaran', RekapTahunanPengeluaranController::class)->name('rekap-tahunan-pengeluaran');

    // Route Tagihan Per Kelas
    Route::get('tagihan-per-kelas', TagihanPerKelasController::class)->name('tagihan-per-kelas');

    // Route Upload Penggajian
    Route::controller(UploadPenggajianController::class)->group(function () {
        Route::get('upload-penggajian', 'index')->name('upload-penggajian');
        Route::post('upload-penggajian', 'upload')->name('upload-penggajian.upload');
    });
});

// Group Guru dan Karyawan
Route::middleware(['auth', 'role:Bendahara|Guru|Humas|Karyawan|Kepala Sekolah|Kesiswaan|Ketenagaan|Konseling|Kreator|Kurikulum|Pembina Ekstrakurikuler|Sarpras|Tata Usaha|Tim Penilai|PPL'])->group(function () {

    // Route Absensi
    Route::controller(AbsensiController::class)->group(function () {
        Route::get('absensi', 'index')->name('absensi');
        Route::post('absensi/nihil', 'nihil')->name('absensi.nihil');
        Route::post('absensi/simpan', 'simpan')->name('absensi.simpan');
    });

    // Route Absensi Ekstrakurikuler
    Route::controller(AbsensiEkstrakurikulerController::class)->group(function () {
        Route::get('absensi-ekstrakurikuler', 'index')->name('absensi-ekstrakurikuler');
        Route::post('absensi-ekstrakurikuler/nihil', 'nihil')->name('absensi-ekstrakurikuler.nihil');
        Route::post('absensi-ekstrakurikuler/simpan', 'simpan')->name('absensi-ekstrakurikuler.simpan');
    });

    // Route Absensi Ujian
    Route::controller(AbsensiUjianController::class)->group(function () {
        Route::get('absensi-ujian', 'index')->name('absensi-ujian');
        Route::post('absensi-ujian/nihil', 'nihil')->name('absensi-ujian.nihil');
        Route::post('absensi-ujian/simpan', 'simpan')->name('absensi-ujian.simpan');
    });

    // Route Data Siswa Ekstrakurikuler
    Route::get('data-siswa-ekstrakurikuler', DataSiswaEkstrakurikulerController::class)->name('data-siswa-ekstrakurikuler');

    // Route Form Tugas
    Route::controller(FormTugasController::class)->group(function () {
        Route::get('form-tugas', 'index')->name('form-tugas');
        Route::post('form-tugas', 'simpan')->name('form-tugas.simpan');
        Route::delete('form-tugas', 'hapus')->name('form-tugas.hapus');
    });

    // Route Input Deskripsi Ekstrakurikuler
    Route::controller(InputDeskripsiEkstrakurikulerController::class)->group(function () {
        Route::get('input-deskripsi-ekstrakurikuler', 'index')->name('input-deskripsi-ekstrakurikuler');
        Route::post('input-deskripsi-ekstrakurikuler', 'simpan')->name('input-deskripsi-ekstrakurikuler.simpan');
        Route::delete('input-deskripsi-ekstrakurikuler', 'hapus')->name('input-deskripsi-ekstrakurikuler.hapus');
    });

    // Route Input Nilai Al Qur'an
    Route::controller(InputNilaiAlquranController::class)->group(function () {
        Route::get('input-nila-alquran', 'index')->name('input-nilai-alquran');
        Route::post('input-nila-alquran', 'simpan')->name('input-nilai-alquran.simpan');
        Route::put('input-nila-alquran', 'semua')->name('input-nilai-alquran.semua');
        Route::delete('input-nila-alquran', 'hapus')->name('input-nilai-alquran.hapus');
    });

    // Route Input Nilai Bilghoib Per Kelas
    Route::controller(InputNilaiBilghoibPerKelasController::class)->group(function () {
        Route::get('input-nilai-bilghoib-per-kelas', 'index')->name('input-nilai-bilghoib-per-kelas');
        Route::post('input-nilai-bilghoib-per-kelas', 'simpan')->name('input-nilai-bilghoib-per-kelas.simpan');
        Route::delete('input-nilai-bilghoib-per-kelas', 'hapus')->name('input-nilai-bilghoib-per-kelas.hapus');
    });

    // Route Input Nilai Binnadzor Per Kelas
    Route::controller(InputNilaiBinnadzorPerKelasController::class)->group(function () {
        Route::get('input-nilai-binnadzor-per-kelas', 'index')->name('input-nilai-binnadzor-per-kelas');
        Route::post('input-nilai-binnadzor-per-kelas', 'simpan')->name('input-nilai-binnadzor-per-kelas.simpan');
        Route::delete('input-nilai-binnadzor-per-kelas', 'hapus')->name('input-nilai-binnadzor-per-kelas.hapus');
    });

    // Route Input Nilai Ekstrakurikuler
    Route::controller(InputNilaiEkstrakurikulerController::class)->group(function () {
        Route::get('input-nilai-ekstrakurikuler', 'index')->name('input-nilai-ekstrakurikuler');
        Route::post('input-nilai-ekstrakurikuler', 'simpan')->name('input-nilai-ekstrakurikuler.simpan');
    });

    // Route Print Absensi Ekstrakurikuler
    Route::controller(PrintAbsensiEkstrakurikulerController::class)->group(function () {
        Route::get('print-absensi-ekstrakurikuler', 'index')->name('print-absensi-ekstrakurikuler');
        Route::get('print-absensi-ekstrakurikuler/download', 'download')->name('print-absensi-ekstrakurikuler.download');
    });

    // Route Print Absensi Kelas
    Route::controller(PrintAbsensiKelasController::class)->group(function () {
        Route::get('print-absensi-kelas', 'index')->name('print-absensi-kelas');
        Route::get('print-absensi-kelas/per-bulan', 'per_bulan')->name('print-absensi-kelas.per-bulan');
        Route::get('print-absensi-kelas/per-semester', 'per_semester')->name('print-absensi-kelas.per-semester');
    });

    // Route Print Absensi Ujian
    Route::controller(PrintAbsensiUjianController::class)->group(function () {
        Route::get('print-absensi-ujian', 'index')->name('print-absensi-ujian');
        Route::get('print-absensi-ujian/print', 'print')->name('print-absensi-ujian.print');
    });

    // Route Print Nilai Al Qur'an
    Route::controller(PrintNilaiAlquranController::class)->group(function () {
        Route::get('print-nilai-alquran', 'index')->name('print-nilai-alquran');
        Route::get('print-nilai-alquran/bilghoib', 'bilghoib')->name('print-nilai-alquran.bilghoib');
        Route::get('print-nilai-alquran/bilghoib-horizontal', 'bilghoib_horizontal')->name('print-nilai-alquran.bilghoib-horizontal');
        Route::get('print-nilai-alquran/bilghoib-per-siswa', 'bilghoib_per_siswa')->name('print-nilai-alquran.bilghoib-per-siswa');
        Route::get('print-nilai-alquran/binnadzor', 'binnadzor')->name('print-nilai-alquran.binnadzor');
        Route::get('print-nilai-alquran/binnadzor-horizontal', 'binnadzor_horizontal')->name('print-nilai-alquran.binnadzor-horizontal');
        Route::get('print-nilai-alquran/binnadzor-per-siswa', 'binnadzor_per_siswa')->name('print-nilai-alquran.binnadzor-per-siswa');
    });

    // Route Upload Analisis Al Qur'an
    Route::controller(UploadAnalisisAlquranController::class)->group(function () {
        Route::get('upload-analisis-alquran', 'index')->name('upload-analisis-alquran');
        Route::get('upload-analisis-alquran/download', 'download')->name('upload-analisis-alquran.download');
        Route::post('upload-analisis-alquran', 'upload')->name('upload-analisis-alquran.upload');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
