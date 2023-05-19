<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;
use App\Traits\SiswaTrait;
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

        try {
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

            $listSiswa = request('arrayInput');

            foreach ($listSiswa as $siswa) {
                $siswa['pengayaan'] ?
                    PengayaanDetail::updateOrCreate(
                        ['id' => $siswa['pengayaan']['id'] ?? null],
                        [
                            'pengayaan_id' => $siswa['pengayaan']['pengayaan_id'],
                            'nis' => $siswa['nis'],
                            'nilai_awal' => $siswa['penilaian']['nilai'],
                            'nilai_pengayaan' => $siswa['pengayaan']['nilai_pengayaan'] ?? null,
                            'tahun' => request('tahun'),
                            'semester' => request('semester'),
                            'tanggal' => request('tanggal'),
                            'kelas_id' => request('kelasId'),
                            'mata_pelajaran_id' => request('mataPelajaranId'),
                            'kategori_nilai_id' => request('kategoriNilaiId'),
                            'jenis_penilaian_id' => request('jenisPenilaianId'),
                        ]
                    )
                    :
                    null;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        return to_route('input-nilai-pengayaan');
    }

    public function hapus()
    {

        PengayaanDetail::destroy(request('pengayaanDetailId'));

        return to_route('input-nilai-pengayaan');
    }
}
