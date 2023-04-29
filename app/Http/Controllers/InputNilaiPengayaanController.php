<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;
use App\Traits\SiswaTrait;
use App\Models\KategoriNilai;
use App\Models\JenisPenilaian;
use App\Models\Pengayaan;
use App\Models\PengayaanDetail;

class InputNilaiPengayaanController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/InputNilaiPengayaan',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listMapel' => $this->data_mapel(),
                'listKelas' => $this->data_kelas(),
                'listKategori' => KategoriNilai::whereIn('id', $this->data_kategori_nilai())
                    ->orderBy('nama')
                    ->get(),
                'listJenis' => JenisPenilaian::whereIn('id', $this->data_jenis_penilaian())
                    ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->orderBy('nama')
                    ->get()
            ]
        );
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'tanggal' => 'required',
            'semester' => 'required',
            'mataPelajaranId' => 'required',
            'kelasId' => 'required',
            'kategoriNilaiId' => 'required',
            'jenisPenilaianId' => 'required',
        ]);

        Pengayaan::updateOrCreate(
            ['id' => request('id')],
            [
                'tahun' => request('tahun'),
                'semester' => request('semester'),
                'tanggal' => request('tanggal'),
                'kelas_id' => request('kelasId'),
                'mata_pelajaran_id' => request('mataPelajaranId'),
                'kategori_nilai_id' => request('kategoriNilaiId'),
                'jenis_penilaian_id' => request('jenisPenilaianId'),
                'ki' => request('ki'),
                'kd' => request('kd'),
                'indikator' => request('indikator'),
                'bentuk_pelaksanaan' => request('bentukPelaksanaan'),
                'banyak_soal' => request('banyakSoal')
            ]
        );

        return to_route('input-nilai-pengayaan', [
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'tanggal' => request('tanggal'),
            'kelasId' => request('kelasId'),
            'mataPelajaranId' => request('mataPelajaranId'),
            'kategoriNilaiId' => request('kategoriNilaiId'),
            'jenisPenilaianId' => request('jenisPenilaianId'),
        ]);
    }

    public function update()
    {
        $pengayaan = Pengayaan::updateOrCreate(
            ['id' => request('pengayaanId')],
            [
                'tahun' => request('tahun'),
                'semester' => request('semester'),
                'tanggal' => request('tanggal'),
                'kelas_id' => request('kelasId'),
                'mata_pelajaran_id' => request('mataPelajaranId'),
                'kategori_nilai_id' => request('kategoriNilaiId'),
                'jenis_penilaian_id' => request('jenisPenilaianId'),
                'ki' => request('ki'),
                'kd' => request('kd'),
                'indikator' => request('indikator'),
                'bentuk_pelaksanaan' => request('bentukPelaksanaan'),
                'banyak_soal' => request('banyakSoal')
            ]
        );

        PengayaanDetail::updateOrCreate(
            ['id' => request('id')],
            [
                'pengayaan_id' => $pengayaan->id,
                'nis' => request('nis'),
                'nilai_awal' => request('nilaiAwal'),
                'nilai_pengayaan' => request('nilaiPengayaan'),
                'tahun' => request('tahun'),
                'semester' => request('semester'),
                'tanggal' => request('tanggal'),
                'kelas_id' => request('kelasId'),
                'mata_pelajaran_id' => request('mataPelajaranId'),
                'kategori_nilai_id' => request('kategoriNilaiId'),
                'jenis_penilaian_id' => request('jenisPenilaianId'),
            ]
        );

        return response()->json([
            // 'listSiswa' => $this->data_siswa_with_nilai_pengayaan(),
            'message' => 'Tersimpan',
            'nis' => request('nis')
        ]);
    }
}
