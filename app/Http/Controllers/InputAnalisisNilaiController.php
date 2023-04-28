<?php

namespace App\Http\Controllers;

use App\Models\AnalisisPenilaian;
use App\Models\JenisPenilaian;
use App\Models\KategoriNilai;
use App\Models\Penilaian;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class InputAnalisisNilaiController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/InputAnalisisNilai',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listKelas' => $this->data_kelas(),
                'listMapel' => $this->data_mapel(),
                'listKategori' => KategoriNilai::whereIn('id', $this->data_kategori_nilai())->orderBy('nama')->get(),
                'listJenis' => JenisPenilaian::whereIn('id', $this->data_jenis_penilaian())
                    ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->orderBy('nama')->get(),
            ]
        );
    }

    public function simpan()
    {
        request()->validate(['jenisPenilaianId' => 'required'], ['jenisPenilaianId.required' => 'Pilih Jenis Penilaian']);

        $nilai =
            intval(request('arrayNilai')[0]['no_1'] ?? null) +
            intval(request('arrayNilai')[0]['no_2'] ?? null) +
            intval(request('arrayNilai')[0]['no_3'] ?? null) +
            intval(request('arrayNilai')[0]['no_4'] ?? null) +
            intval(request('arrayNilai')[0]['no_5'] ?? null) +
            intval(request('arrayNilai')[0]['no_6'] ?? null) +
            intval(request('arrayNilai')[0]['no_7'] ?? null) +
            intval(request('arrayNilai')[0]['no_8'] ?? null) +
            intval(request('arrayNilai')[0]['no_9'] ?? null) +
            intval(request('arrayNilai')[0]['no_10'] ?? null);

        AnalisisPenilaian::updateOrCreate(
            ['id' => request('id')],
            [
                'tanggal' => date('Y-m-d'),
                'nis' => request('nis'),
                'kategori_nilai_id' => request('kategoriNilaiId'),
                'jenis_penilaian_id' => request('jenisPenilaianId'),
                'kelas_id' => request('kelasId'),
                'mata_pelajaran_id' => request('mataPelajaranId'),
                'semester' => request('semester'),
                'tahun' => request('tahun'),
                'no_1' => request('arrayNilai')[0]['no_1'] ?? null,
                'no_2' => request('arrayNilai')[0]['no_2'] ?? null,
                'no_3' => request('arrayNilai')[0]['no_3'] ?? null,
                'no_4' => request('arrayNilai')[0]['no_4'] ?? null,
                'no_5' => request('arrayNilai')[0]['no_5'] ?? null,
                'no_6' => request('arrayNilai')[0]['no_6'] ?? null,
                'no_7' => request('arrayNilai')[0]['no_7'] ?? null,
                'no_8' => request('arrayNilai')[0]['no_8'] ?? null,
                'no_9' => request('arrayNilai')[0]['no_9'] ?? null,
                'no_10' => request('arrayNilai')[0]['no_10'] ?? null,
                'nilai' => $nilai,
                'user_id' => auth()->user()->id
            ]
        );

        Penilaian::updateOrCreate(
            ['id' => request('idPenilaian')],
            [
                'tanggal' => date('Y-m-d'),
                'nis' => request('nis'),
                'kategori_nilai_id' => request('kategoriNilaiId'),
                'jenis_penilaian_id' => request('jenisPenilaianId'),
                'kelas_id' => request('kelasId'),
                'mata_pelajaran_id' => request('mataPelajaranId'),
                'semester' => request('semester'),
                'tahun' => request('tahun'),
                'nilai' => $nilai,
                'user_id' => auth()->user()->id
            ]
        );

        return response()->json([
            'listSiswa' => $this->data_siswa_with_analisis_nilai(),
            'message' => 'Tersimpan',
            'nis' => request('nis')
        ]);
    }
}
