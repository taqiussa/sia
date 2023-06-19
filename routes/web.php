<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CekKdController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\GetDataController;
use App\Http\Controllers\InputKdController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataSkorController;
use App\Http\Controllers\SlipGajiController;
use App\Http\Controllers\DataNilaiController;
use App\Http\Controllers\FormTugasController;
use App\Http\Controllers\GetDataBkController;
use App\Http\Controllers\GetDataKdController;
use App\Http\Controllers\HapusSkorController;
use App\Http\Controllers\InputSkorController;
use App\Http\Controllers\ListBadalController;
use App\Http\Controllers\RekapSkorController;
use App\Http\Controllers\SaldoSkorController;
use App\Http\Controllers\InputAlphaController;
use App\Http\Controllers\InputNilaiController;
use App\Http\Controllers\KasBulananController;
use App\Http\Controllers\KasTahunanController;
use App\Http\Controllers\PrintRaporController;
use App\Http\Controllers\GetDataGuruController;
use App\Http\Controllers\GetDataSkorController;
use App\Http\Controllers\UploadNilaiController;
use App\Http\Controllers\AbsensiUjianController;
use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\BiodataSiswaController;
use App\Http\Controllers\GetDataMapelController;
use App\Http\Controllers\GetDataSiswaController;
use App\Http\Controllers\CariDataSiswaController;
use App\Http\Controllers\DataBimbinganController;
use App\Http\Controllers\DataPemasukanController;
use App\Http\Controllers\InputPrestasiController;
use App\Http\Controllers\PrintAnalisisController;
use App\Http\Controllers\PrintRaporPtsController;
use App\Http\Controllers\RekapPerSiswaController;
use App\Http\Controllers\AturNamaElemenController;
use App\Http\Controllers\AturNamaProyekController;
use App\Http\Controllers\AturPulangAwalController;
use App\Http\Controllers\AturWajibBayarController;
use App\Http\Controllers\BendaharaPrintController;
use App\Http\Controllers\CekListAbsensiController;
use App\Http\Controllers\DownloadQrCodeController;
use App\Http\Controllers\GetDataAbsensiController;
use App\Http\Controllers\InputPemasukanController;
use App\Http\Controllers\InputSkorKelasController;
use App\Http\Controllers\PrintLedgerPtsController;
use App\Http\Controllers\RekapBimbinganController;
use App\Http\Controllers\RekapJamKosongController;
use App\Http\Controllers\RekapKehadiranController;
use App\Http\Controllers\AbsensiKaryawanController;
use App\Http\Controllers\AlquranBilghoibController;
use App\Http\Controllers\AturNamaDimensiController;
use App\Http\Controllers\DataPengeluaranController;
use App\Http\Controllers\InputNilaiSikapController;
use App\Http\Controllers\JadwalJamKosongController;
use App\Http\Controllers\PermintaanBadalController;
use App\Http\Controllers\PrintNilaiSikapController;
use App\Http\Controllers\RekapPenggajianController;
use App\Http\Controllers\TagihanPerKelasController;
use App\Http\Controllers\AlquranBinnadzorController;
use App\Http\Controllers\GetDataBendaharaController;
use App\Http\Controllers\GetDataPenilaianController;
use App\Http\Controllers\InputNilaiProyekController;
use App\Http\Controllers\InputNilaiRemidiController;
use App\Http\Controllers\InputPengeluaranController;
use App\Http\Controllers\PrintDaftarNilaiController;
use App\Http\Controllers\PrintLedgerRaporController;
use App\Http\Controllers\PrintNilaiRemidiController;
use App\Http\Controllers\PrintRaporProyekController;
use App\Http\Controllers\UploadNilaiSikapController;
use App\Http\Controllers\UploadPenggajianController;
use App\Http\Controllers\AbsensiKetenagaanController;
use App\Http\Controllers\AturNamaSubElemenController;
use App\Http\Controllers\BimbinganIndividuController;
use App\Http\Controllers\CekPenilaianKelasController;
use App\Http\Controllers\GetDataKetenagaanController;
use App\Http\Controllers\InputCatatanRaporController;
use App\Http\Controllers\InputNilaiAlquranController;
use App\Http\Controllers\PrintAbsensiKelasController;
use App\Http\Controllers\PrintAbsensiUjianController;
use App\Http\Controllers\PrintNilaiAlquranController;
use App\Http\Controllers\UploadNilaiProyekController;
use App\Http\Controllers\InputAnalisisNilaiController;
use App\Http\Controllers\AturPenilaianProyekController;
use App\Http\Controllers\DataPembayaranSiswaController;
use App\Http\Controllers\InputNilaiPengayaanController;
use App\Http\Controllers\PrintNilaiPengayaanController;
use App\Http\Controllers\UploadAnalisisNilaiController;
use App\Http\Controllers\InputPembayaranSiswaController;
use App\Http\Controllers\RekapHarianPemasukanController;
use App\Http\Controllers\RekapPembayaranSiswaController;
use App\Http\Controllers\AturKategoriPemasukanController;
use App\Http\Controllers\RekapTahunanPemasukanController;
use App\Http\Controllers\UploadAnalisisAlquranController;
use App\Http\Controllers\AbsensiEkstrakurikulerController;
use App\Http\Controllers\GetDataAbsensiKaryawanController;
use App\Http\Controllers\RekapHarianPengeluaranController;
use App\Http\Controllers\AturKategoriPengeluaranController;
use App\Http\Controllers\InputSkorBirrulWalidainController;
use App\Http\Controllers\RekapTahunanPengeluaranController;
use App\Http\Controllers\DataSiswaEkstrakurikulerController;
use App\Http\Controllers\RekapAbsensiGuruKaryawanController;
use App\Http\Controllers\InputNilaiEkstrakurikulerController;
use App\Http\Controllers\PrintNilaiEkstrakurikulerController;
use App\Http\Controllers\PrintPencapaianKompetensiController;
use App\Http\Controllers\InputNilaiBilghoibPerKelasController;
use App\Http\Controllers\InputNilaiBinnadzorPerKelasController;
use App\Http\Controllers\PrintAbsensiEkstrakurikulerController;
use App\Http\Controllers\InputDeskripsiEkstrakurikulerController;
use App\Http\Controllers\PendaftaranSiswaEkstrakurikulerController;

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

// Group Guru dan Karyawan
Route::middleware(['auth', 'role:Bendahara|Guru|Humas|Karyawan|Kepala Sekolah|Kesiswaan|Ketenagaan|Konseling|Kreator|Kurikulum|Pembina Ekstrakurikuler|Sarpras|Tata Usaha|Tim Penilai|PPL'])->group(function () {

    // Route Atur Pulang Awal
    Route::controller(AturPulangAwalController::class)->group(function () {
        Route::get('atur-pulang-awal', 'index')->name('atur-pulang-awal');
        Route::post('atur-pulang-awal', 'simpan')->name('atur-pulang-awal.simpan');
        Route::delete('atur-pulang-awal', 'hapus')->name('atur-pulang-awal.hapus');
    });

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

    // Route Biodata Siswa
    Route::controller(BiodataSiswaController::class)->group(function () {
        Route::get('biodata-siswa', 'index')->name('biodata-siswa');
    });

    // Route Bimbingan Individu
    Route::controller(BimbinganIndividuController::class)->group(function () {
        Route::get('bimbingan-individu', 'index')->name('bimbingan-individu');
        Route::post('bimbingan-individu', 'simpan')->name('bimbingan-individu.simpan');
    });

    // Route Cari Data Siswa
    Route::get('cari-data-siswa', CariDataSiswaController::class)->name('cari-data-siswa');

    // Route Cek Kd
    Route::get('cek-kd', CekKdController::class)->name('cek-kd');

    // Route Cek List Absensi
    Route::get('cek-list-absensi', CekListAbsensiController::class)->name('cek-list-absensi');

    // Route Cek Penilaian
    Route::get('cek-penilaian-kelas', CekPenilaianKelasController::class)->name('cek-penilaian-kelas');

    // Route Data Siswa Ekstrakurikuler
    Route::get('data-siswa-ekstrakurikuler', DataSiswaEkstrakurikulerController::class)->name('data-siswa-ekstrakurikuler');

    // Route Download Qr Code
    Route::controller(DownloadQrCodeController::class)->group(function () {
        Route::get('download-qr-code', 'index')->name('download-qr-code');
    });

    // Route Form Tugas
    Route::controller(FormTugasController::class)->group(function () {
        Route::get('form-tugas', 'index')->name('form-tugas');
        Route::post('form-tugas', 'simpan')->name('form-tugas.simpan');
        Route::delete('form-tugas', 'hapus')->name('form-tugas.hapus');
    });

    // Route Hapus Skor
    Route::controller(HapusSkorController::class)->group(function () {
        Route::get('hapus-skor', 'index')->name('hapus-skor');
        Route::delete('hapus-skor', 'hapus')->name('hapus-skor.hapus');
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
        Route::delete('input-nilai', 'hapus')->name('input-nilai.hapus');
    });

    // Route Input Nilai Al Qur'an
    Route::controller(InputNilaiAlquranController::class)->group(function () {
        Route::get('input-nilai-alquran', 'index')->name('input-nilai-alquran');
        Route::post('input-nilai-alquran', 'simpan')->name('input-nilai-alquran.simpan');
        Route::put('input-nilai-alquran', 'semua')->name('input-nilai-alquran.semua');
        Route::delete('input-nilai-alquran', 'hapus')->name('input-nilai-alquran.hapus');
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
        Route::delete('input-nilai-ekstrakurikuler', 'hapus')->name('input-nilai-ekstrakurikuler.hapus');
    });

    // Route Input Nilai Proyek
    Route::controller(InputNilaiProyekController::class)->group(function () {
        Route::get('input-nilai-proyek', 'index')->name('input-nilai-proyek');
        Route::post('input-nilai-proyek', 'simpan')->name('input-nilai-proyek.simpan');
        Route::put('input-nilai-proyek', 'update')->name('input-nilai-proyek.update');
        Route::delete('input-nilai-proyek', 'hapus')->name('input-nilai-proyek.hapus');
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
        Route::delete('input-nilai-sikap', 'hapus')->name('input-nilai-sikap.hapus');
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

    // Route Input Skor Kelas
    Route::controller(InputSkorKelasController::class)->group(function () {
        Route::get('input-skor-kelas', 'index')->name('input-skor-kelas');
        Route::post('input-skor-kelas', 'simpan')->name('input-skor-kelas.simpan');
        Route::delete('input-skor-kelas', 'hapus')->name('input-skor-kelas.hapus');
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
        Route::get('print-ledger-rapor/download', 'download')->name('print-ledger-rapor.download');
        Route::get('print-ledger-rapor/print-ranking', 'print_ranking')->name('print-ledger-rapor.print-ranking');
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

    // Route Print Rapor Proyek
    Route::controller(PrintRaporProyekController::class)->group(function () {
        Route::get('print-rapor-proyek', 'index')->name('print-rapor-proyek');
        Route::get('print-rapor-proyek/download', 'download')->name('print-rapor-proyek.download');
    });

    // Route Print Rapor PTS
    Route::controller(PrintRaporPtsController::class)->group(function () {
        Route::get('print-rapor-pts', 'index')->name('print-rapor-pts');
        Route::get('print-rapor-pts/download', 'download')->name('print-rapor-pts.download');
    });

    // Route Rekap Bimbingan
    Route::controller(RekapBimbinganController::class)->group(function () {
        Route::get('rekap-bimbingan', 'index')->name('rekap-bimbingan');
        Route::get('rekap-bimbingan/detail', 'detail')->name('rekap-bimbingan.detail');
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

    // Route Rekap Skor
    Route::controller(RekapSkorController::class)->group(function () {
        Route::get('rekap-skor', 'index')->name('rekap-skor');
        Route::delete('rekap-skor', 'hapus')->name('rekap-skor.hapus');
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

    // Route Upload Nilai Proyek
    Route::controller(UploadNilaiProyekController::class)->group(function () {
        Route::get('upload-nilai-proyek', 'index')->name('upload-nilai-proyek');
        Route::get('upload-nilai-proyek/download', 'download')->name('upload-nilai-proyek.download');
        Route::post('upload-nilai-proyek', 'upload')->name('upload-nilai-proyek.upload');
    });

    // Route Upload Nilai Sikap
    Route::controller(UploadNilaiSikapController::class)->group(function () {
        Route::get('upload-nilai-sikap', 'index')->name('upload-nilai-sikap');
        Route::get('upload-nilai-sikap/download', 'download')->name('upload-nilai-sikap.download');
        Route::post('upload-nilai-sikap', 'upload')->name('upload-nilai-sikap.upload');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/bendahara.php';
require __DIR__ . '/blockip.php';
require __DIR__ . '/data.php';
require __DIR__ . '/kurikulum.php';
