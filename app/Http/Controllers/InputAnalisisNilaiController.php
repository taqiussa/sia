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

        $listSiswa = request('arrayInput');

        foreach ($listSiswa as $siswa) {

            if ($siswa['analisis_penilaian']) {

                $nilai =
                    $siswa['analisis_penilaian']['no_1'] ?? null +
                    $siswa['analisis_penilaian']['no_2'] ?? null +
                    $siswa['analisis_penilaian']['no_3'] ?? null +
                    $siswa['analisis_penilaian']['no_4'] ?? null +
                    $siswa['analisis_penilaian']['no_5'] ?? null +
                    $siswa['analisis_penilaian']['no_6'] ?? null +
                    $siswa['analisis_penilaian']['no_7'] ?? null +
                    $siswa['analisis_penilaian']['no_8'] ?? null +
                    $siswa['analisis_penilaian']['no_9'] ?? null +
                    $siswa['analisis_penilaian']['no_10'] ?? null;

                AnalisisPenilaian::updateOrCreate(
                    ['id' => $siswa['analisis_penilaian']['id'] ?? null],
                    [
                        'tanggal' => date('Y-m-d'),
                        'nis' => $siswa['nis'],
                        'kategori_nilai_id' => request('kategoriNilaiId'),
                        'jenis_penilaian_id' => request('jenisPenilaianId'),
                        'kelas_id' => request('kelasId'),
                        'mata_pelajaran_id' => request('mataPelajaranId'),
                        'semester' => request('semester'),
                        'tahun' => request('tahun'),
                        'no_1' => $siswa['analisis_penilaian']['no_1'] ?? null,
                        'no_2' => $siswa['analisis_penilaian']['no_2'] ?? null,
                        'no_3' => $siswa['analisis_penilaian']['no_3'] ?? null,
                        'no_4' => $siswa['analisis_penilaian']['no_4'] ?? null,
                        'no_5' => $siswa['analisis_penilaian']['no_5'] ?? null,
                        'no_6' => $siswa['analisis_penilaian']['no_6'] ?? null,
                        'no_7' => $siswa['analisis_penilaian']['no_7'] ?? null,
                        'no_8' => $siswa['analisis_penilaian']['no_8'] ?? null,
                        'no_9' => $siswa['analisis_penilaian']['no_9'] ?? null,
                        'no_10' => $siswa['analisis_penilaian']['no_10'] ?? null,
                        'nilai' => $nilai,
                        'user_id' => auth()->user()->id
                    ]
                );


                Penilaian::updateOrCreate(
                    ['id' => $siswa['penilaian']['id'] ?? null],
                    [
                        'tanggal' => date('Y-m-d'),
                        'nis' => $siswa['nis'],
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
            } else {
                null;
            }
        }


        return to_route('input-analisis-nilai');
    }
}
