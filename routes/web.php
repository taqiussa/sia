<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AbsensiEkstrakurikulerController;
use App\Http\Controllers\AbsensiUjianController;
use App\Http\Controllers\AturKategoriPemasukanController;
use App\Http\Controllers\AturKategoriPengeluaranController;
use App\Http\Controllers\AturWajibBayarController;
use App\Http\Controllers\BendaharaPrintController;
use App\Http\Controllers\BimbinganIndividuController;
use App\Http\Controllers\CariDataSiswaController;
use App\Http\Controllers\CekListAbsensiController;
use App\Http\Controllers\DataPemasukanController;
use App\Http\Controllers\DataPembayaranSiswaController;
use App\Http\Controllers\DataPengeluaranController;
use App\Http\Controllers\DataSiswaEkstrakurikulerController;
use App\Http\Controllers\FormTugasController;
use App\Http\Controllers\GetDataAbsensiController;
use App\Http\Controllers\GetDataBendaharaController;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\GetDataGuruController;
use App\Http\Controllers\GetDataKetenagaanController;
use App\Http\Controllers\GetDataPenilaianController;
use App\Http\Controllers\GetDataSkorController;
use App\Http\Controllers\InputAlphaController;
use App\Http\Controllers\InputAnalisisNilaiController;
use App\Http\Controllers\InputCatatanRaporController;
use App\Http\Controllers\InputDeskripsiEkstrakurikulerController;
use App\Http\Controllers\InputKdController;
use App\Http\Controllers\InputNilaiAlquranController;
use App\Http\Controllers\InputNilaiBilghoibPerKelasController;
use App\Http\Controllers\InputNilaiBinnadzorPerKelasController;
use App\Http\Controllers\InputNilaiController;
use App\Http\Controllers\InputNilaiEkstrakurikulerController;
use App\Http\Controllers\InputNilaiPengayaanController;
use App\Http\Controllers\InputNilaiRemidiController;
use App\Http\Controllers\InputNilaiSikapController;
use App\Http\Controllers\InputPemasukanController;
use App\Http\Controllers\InputPembayaranSiswaController;
use App\Http\Controllers\InputPengeluaranController;
use App\Http\Controllers\InputPrestasiController;
use App\Http\Controllers\InputSkorBirrulWalidainController;
use App\Http\Controllers\InputSkorController;
use App\Http\Controllers\JadwalJamKosongController;
use App\Http\Controllers\KasBulananController;
use App\Http\Controllers\KasTahunanController;
use App\Http\Controllers\ListBadalController;
use App\Http\Controllers\PendaftaranSiswaEkstrakurikulerController;
use App\Http\Controllers\PermintaanBadalController;
use App\Http\Controllers\PrintAbsensiEkstrakurikulerController;
use App\Http\Controllers\PrintAbsensiKelasController;
use App\Http\Controllers\PrintAbsensiUjianController;
use App\Http\Controllers\PrintAnalisisController;
use App\Http\Controllers\PrintDaftarNilaiController;
use App\Http\Controllers\PrintLedgerPtsController;
use App\Http\Controllers\PrintLedgerRaporController;
use App\Http\Controllers\PrintNilaiAlquranController;
use App\Http\Controllers\PrintNilaiEkstrakurikulerController;
use App\Http\Controllers\PrintNilaiPengayaanController;
use App\Http\Controllers\PrintNilaiRemidiController;
use App\Http\Controllers\PrintNilaiSikapController;
use App\Http\Controllers\PrintPencapaianKompetensiController;
use App\Http\Controllers\PrintRaporController;
use App\Http\Controllers\PrintRaporPtsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RekapBimbinganController;
use App\Http\Controllers\RekapHarianPemasukanController;
use App\Http\Controllers\RekapHarianPengeluaranController;
use App\Http\Controllers\RekapJamKosongController;
use App\Http\Controllers\RekapKehadiranController;
use App\Http\Controllers\RekapPembayaranSiswaController;
use App\Http\Controllers\RekapPenggajianController;
use App\Http\Controllers\RekapPerSiswaController;
use App\Http\Controllers\RekapTahunanPemasukanController;
use App\Http\Controllers\RekapTahunanPengeluaranController;
use App\Http\Controllers\SaldoSkorController;
use App\Http\Controllers\SlipGajiController;
use App\Http\Controllers\TagihanPerKelasController;
use App\Http\Controllers\UploadAnalisisAlquranController;
use App\Http\Controllers\UploadAnalisisNilaiController;
use App\Http\Controllers\UploadNilaiController;
use App\Http\Controllers\UploadPenggajianController;
use Illuminate\Support\Facades\Route;

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
    return inertia('Dashboard');
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
    Route::controller(GetDataAbsensiController::class)->group(function () {
        Route::post('get-absensi-ekstrakurikuler', 'get_absensi_ekstrakurikuler')->name('get-absensi-ekstrakurikuler');
        Route::post('get-absensi-kelas', 'get_absensi_kelas')->name('get-absensi-kelas');
        Route::post('get-absensi-siswa', 'get_absensi_siswa')->name('get-absensi-siswa');
        Route::post('get-absensi-ujian', 'get_absensi_ujian')->name('get-absensi-ujian');
        Route::post('get-info-absensi', 'get_info_absensi')->name('get-info-absensi');
        Route::post('get-siswa-with-alpha', 'get_siswa_with_alpha')->name('get-siswa-with-alpha');
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
        Route::post('get-siswa', 'get_siswa')->name('get-siswa');
        Route::post('get-siswa-with-catatan', 'get_siswa_with_catatan')->name('get-siswa-with-catatan');
    });

    // Route Get Data Guru
    Route::controller(GetDataGuruController::class)->group(function () {
        Route::post('get-kelas-wali-kelas', 'get_kelas_wali_kelas')->name('get-kelas-wali-kelas');
    });

    // Route Get Data Ketenagaan
    Route::controller(GetDataKetenagaanController::class)->group(function () {
        Route::post('get-guru-izin', 'get_guru_izin')->name('get-guru-izin');
        Route::post('get-guru-kosong', 'get_guru_kosong')->name('get-guru-kosong');
        Route::post('get-guru-sudah-badal', 'get_guru_sudah_badal')->name('get-guru-sudah-badal');
        Route::post('get-permintaan-badal', 'get_permintaan_badal')->name('get-permintaan-badal');
    });

    // Route Get Data Penilaian
    Route::controller(GetDataPenilaianController::class)->group(function () {
        Route::post('get-siswa-ekstra-with-nilai', 'get_siswa_ekstra_with_nilai')->name('get-siswa-ekstra-with-nilai');
        Route::post('get-siswa-pengayaan', 'get_siswa_pengayaan')->name('get-siswa-pengayaan');
        Route::post('get-siswa-remidi', 'get_siswa_remidi')->name('get-siswa-remidi');
        Route::post('get-siswa-with-analisis-nilai', 'get_siswa_with_analisis_nilai')->name('get-siswa-with-analisis-nilai');
        Route::post('get-siswa-with-nilai', 'get_siswa_with_nilai')->name('get-siswa-with-nilai');
        Route::post('get-siswa-with-nilai-sikap', 'get_siswa_with_nilai_sikap')->name('get-siswa-with-nilai-sikap');
    });

    // Route Get Data Skor
    Route::controller(GetDataSkorController::class)->group(function () {
        // Route::post('get-siswa-with-skor', 'get_siswa_with_skor')->name('get-siswa-with-skor');
        // Route::post('get-siswa-with-skor-wali-kelas', 'get_siswa_with_skor_wali_kelas')->name('get-siswa-with-skor-wali-kelas');
        Route::post('get-skor-siswa', 'get_skor_siswa')->name('get-skor-siswa');
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

    // Route Bimbingan Individu
    Route::controller(BimbinganIndividuController::class)->group(function () {
        Route::get('bimbingan-individu', 'index')->name('bimbingan-individu');
        Route::post('bimbingan-individu', 'simpan')->name('bimbingan-individu.simpan');
    });

    // Route Cari Data Siswa
    Route::get('cari-data-siswa', CariDataSiswaController::class)->name('cari-data-siswa');

    // Route Cek List Absensi
    Route::get('cek-list-absensi', CekListAbsensiController::class)->name('cek-list-absensi');

    // Route Data Siswa Ekstrakurikuler
    Route::get('data-siswa-ekstrakurikuler', DataSiswaEkstrakurikulerController::class)->name('data-siswa-ekstrakurikuler');

    // Route Form Tugas
    Route::controller(FormTugasController::class)->group(function () {
        Route::get('form-tugas', 'index')->name('form-tugas');
        Route::post('form-tugas', 'simpan')->name('form-tugas.simpan');
        Route::delete('form-tugas', 'hapus')->name('form-tugas.hapus');
    });

    // Route Input Alpha
    Route::controller(InputAlphaController::class)->group(function () {
        Route::get('input-alpha', 'index')->name('input-alpha');
        Route::post('input-alpha', 'simpan')->name('input-alpha.simpan');
        Route::delete('input-alpha', 'hapus')->name('input-alpha.hapus');
    });

    // Route Input Catatan Rapor
    Route::controller(InputCatatanRaporController::class)->group(function () {
        Route::get('input-catatan-rapor', 'index')->name('input-catatan-rapor');
        Route::post('input-catatan-rapor', 'simpan')->name('input-catatan-rapor.simpan');
        Route::delete('input-catatan-rapor', 'hapus')->name('input-catatan-rapor.hapus');
    });

    // Route Input Analisis Nilai
    Route::controller(InputAnalisisNilaiController::class)->group(function () {
        Route::get('input-analisis-nilai', 'index')->name('input-analisis-nilai');
        Route::post('input-analisis-nilai', 'simpan')->name('input-analisis-nilai.simpan');
    });

    // Route Input Deskripsi Ekstrakurikuler
    Route::controller(InputDeskripsiEkstrakurikulerController::class)->group(function () {
        Route::get('input-deskripsi-ekstrakurikuler', 'index')->name('input-deskripsi-ekstrakurikuler');
        Route::post('input-deskripsi-ekstrakurikuler', 'simpan')->name('input-deskripsi-ekstrakurikuler.simpan');
        Route::delete('input-deskripsi-ekstrakurikuler', 'hapus')->name('input-deskripsi-ekstrakurikuler.hapus');
    });

    // Route Input Kd
    Route::controller(InputKdController::class)->group(function () {
        Route::get('input-kd', 'index')->name('input-kd');
        Route::post('input-kd', 'simpan')->name('input-kd.simpan');
        Route::delete('input-kd', 'hapus')->name('input-kd.hapus');
    });

    // Route Input Nilai
    Route::controller(InputNilaiController::class)->group(function () {
        Route::get('input-nilai', 'index')->name('input-nilai');
        Route::post('input-nilai', 'simpan')->name('input-nilai.simpan');
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

    // Route Input Nilai Pengayaan
    Route::controller(InputNilaiPengayaanController::class)->group(function () {
        Route::get('input-nilai-pengayaan', 'index')->name('input-nilai-pengayaan');
        Route::post('input-nilai-pengayaan', 'simpan')->name('input-nilai-pengayaan.simpan');
        Route::put('input-nilai-pengayaan', 'update')->name('input-nilai-pengayaan.update');
        Route::delete('input-nilai-pengayaan', 'hapus')->name('input-nilai-pengayaan.hapus');
    });

    // Route Input Nilai Remidi
    Route::controller(InputNilaiRemidiController::class)->group(function () {
        Route::get('input-nilai-remidi', 'index')->name('input-nilai-remidi');
        Route::post('input-nilai-remidi', 'simpan')->name('input-nilai-remidi.simpan');
        Route::put('input-nilai-remidi', 'update')->name('input-nilai-remidi.update');
        Route::delete('input-nilai-remidi', 'hapus')->name('input-nilai-remidi.hapus');
    });

    // Route Input Nilai Sikap
    Route::controller(InputNilaiSikapController::class)->group(function () {
        Route::get('input-nilai-sikap', 'index')->name('input-nilai-sikap');
        Route::post('input-nilai-sikap', 'simpan')->name('input-nilai-sikap.simpan');
    });

    // Route Input Prestasi
    Route::controller(InputPrestasiController::class)->group(function () {
        Route::get('input-prestasi', 'index')->name('input-prestasi');
        Route::post('input-prestasi', 'simpan')->name('input-prestasi.simpan');
        Route::delete('input-prestasi', 'hapus')->name('input-prestasi.hapus');
    });

    // Route Input Skor
    Route::controller(InputSkorController::class)->group(function () {
        Route::get('input-skor', 'index')->name('input-skor');
        Route::post('input-skor', 'simpan')->name('input-skor.simpan');
        Route::delete('input-skor', 'hapus')->name('input-skor.hapus');
    });

    // Route Input Skor Birrul Walidain
    Route::controller(InputSkorBirrulWalidainController::class)->group(function () {
        Route::get('input-skor-birrul-walidain', 'index')->name('input-skor-birrul-walidain');
        Route::post('input-skor-birrul-walidain', 'simpan')->name('input-skor-birrul-walidain.simpan');
        Route::delete('input-skor-birrul-walidain', 'hapus')->name('input-skor-birrul-walidain.hapus');
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

    // Route Pendaftaran Siswa Ekstrakurikuler
    Route::controller(PendaftaranSiswaEkstrakurikulerController::class)->group(function () {
        Route::get('pendaftaran-siswa-ekstrakurikuler', 'index')->name('pendaftaran-siswa-ekstrakurikuler');
        Route::post('pendaftaran-siswa-ekstrakurikuler', 'simpan')->name('pendaftaran-siswa-ekstrakurikuler.simpan');
        Route::delete('pendaftaran-siswa-ekstrakurikuler', 'hapus')->name('pendaftaran-siswa-ekstrakurikuler.hapus');
    });

    Route::controller(PermintaanBadalController::class)->group(function () {
        Route::get('permintaan-badal', 'index')->name('permintaan-badal');
        Route::post('permintaan-badal', 'simpan')->name('permintaan-badal.simpan');
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

    // Route Print Analisis
    Route::controller(PrintAnalisisController::class)->group(function () {
        Route::get('print-analisis', 'index')->name('print-analisis');
        Route::get('print-analisis/print', 'print')->name('print-analisis.print');
    });

    // Route Print Daftar Nilai
    Route::controller(PrintDaftarNilaiController::class)->group(function () {
        Route::get('print-daftar-nilai', 'index')->name('print-daftar-nilai');
        Route::get('print-daftar-nilai/print', 'print')->name('print-daftar-nilai.print');
    });

    // Route Print Ledger PTS
    Route::controller(PrintLedgerPtsController::class)->group(function () {
        Route::get('print-ledger-pts', 'index')->name('print-ledger-pts');
        Route::get('print-ledger-pts/print', 'print')->name('print-ledger-pts.print');
    });

    // Route Print Ledger Rapor
    Route::controller(PrintLedgerRaporController::class)->group(function () {
        Route::get('print-ledger-rapor', 'index')->name('print-ledger-rapor');
        Route::get('print-ledger-rapor/print', 'print')->name('print-ledger-rapor.print');
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

    // Route Print Nilai Ekstrakurikuler
    Route::controller(PrintNilaiEkstrakurikulerController::class)->group(function () {
        Route::get('print-nilai-ekstrakurikuler', 'index')->name('print-nilai-ekstrakurikuler');
        Route::get('print-nilai-ekstrakurikuler/per-kelas', 'per_kelas')->name('print-nilai-ekstrakurikuler.per-kelas');
        Route::get('print-nilai-ekstrakurikuler/per-ekstrakurikuler', 'per_ekstrakurikuler')->name('print-nilai-ekstrakurikuler.per-ekstrakurikuler');
    });

    // Route Print Nilai Pengayaan
    Route::controller(PrintNilaiPengayaanController::class)->group(function () {
        Route::get('print-nilai-pengayaan', 'index')->name('print-nilai-pengayaan');
        Route::get('print-nilai-pengayaan/print', 'print')->name('print-nilai-pengayaan.print');
    });

    // Route Print Nilai Remidi
    Route::controller(PrintNilaiRemidiController::class)->group(function () {
        Route::get('print-nilai-remidi', 'index')->name('print-nilai-remidi');
        Route::get('print-nilai-remidi/print', 'print')->name('print-nilai-remidi.print');
    });

    // Route Print Nilai Sikap
    Route::controller(PrintNilaiSikapController::class)->group(function () {
        Route::get('print-nilai-sikap', 'index')->name('print-nilai-sikap');
        Route::get('print-nilai-sikap/print', 'print')->name('print-nilai-sikap.print');
    });

    // Route Print Pencapaian Kompetensi
    Route::controller(PrintPencapaianKompetensiController::class)->group(function () {
        Route::get('print-pencapaian-kompetensi', 'index')->name('print-pencapaian-kompetensi');
        Route::get('print-pencapaian-kompetensi/print', 'print')->name('print-pencapaian-kompetensi.print');
    });

    // Route Print Rapor
    Route::controller(PrintRaporController::class)->group(function () {
        Route::get('print-rapor', 'index')->name('print-rapor');
        Route::get('print-rapor/download', 'download')->name('print-rapor.download');
    });

    // Route Print Rapor PTS
    Route::controller(PrintRaporPtsController::class)->group(function () {
        Route::get('print-rapor-pts', 'index')->name('print-rapor-pts');
        Route::get('print-rapor-pts/download', 'download')->name('print-rapor-pts.download');
    });

    // Route Rekap Bimbingan
    Route::controller(RekapBimbinganController::class)->group(function () {
        Route::get('rekap-bimbingan', 'index')->name('rekap-bimbingan');
        Route::delete('rekap-bimbingan', 'hapus')->name('rekap-bimbingan.hapus');
    });

    // Route Rekap Jam Kosong
    Route::get('rekap-jam-kosong', RekapJamKosongController::class)->name('rekap-jam-kosong');

    Route::controller(RekapKehadiranController::class)->group(function () {
        Route::get('rekap-kehadiran', 'index')->name('rekap-kehadiran');
        Route::get('rekap-kehadiran/detail', 'detail')->name('rekap-kehadiran.detail');
        Route::post('rekap-kehadiran', 'simpan')->name('rekap-kehadiran.simpan');
    });

    // Route Rekap Pembayaran Siswa
    Route::controller(RekapPembayaranSiswaController::class)->group(function () {
        Route::get('rekap-pembayaran-siswa', 'index')->name('rekap-pembayaran-siswa');
        Route::get('rekap-pembayaran-siswa/print', 'print')->name('rekap-pembayaran-siswa.print');
    });

    // Route Saldo Skor
    Route::get('saldo-skor', SaldoSkorController::class)->name('saldo-skor');

    // Route Upload Analisis Al Qur'an
    Route::controller(UploadAnalisisAlquranController::class)->group(function () {
        Route::get('upload-analisis-alquran', 'index')->name('upload-analisis-alquran');
        Route::get('upload-analisis-alquran/download', 'download')->name('upload-analisis-alquran.download');
        Route::post('upload-analisis-alquran', 'upload')->name('upload-analisis-alquran.upload');
    });

    // Route Upload Analisis Nilai
    Route::controller(UploadAnalisisNilaiController::class)->group(function () {
        Route::get('upload-analisis-nilai', 'index')->name('upload-analisis-nilai');
        Route::get('upload-analisis-nilai/download', 'download')->name('upload-analisis-nilai.download');
        Route::post('upload-analisis-nilai', 'upload')->name('upload-analisis-nilai.upload');
    });

    // Route Upload Nilai
    Route::controller(UploadNilaiController::class)->group(function () {
        Route::get('upload-nilai', 'index')->name('upload-nilai');
        Route::get('upload-nilai/download', 'download')->name('upload-nilai.download');
        Route::post('upload-nilai', 'upload')->name('upload-nilai.upload');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
