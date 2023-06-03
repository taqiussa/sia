<?php

namespace App\Http\Controllers;

use App\Models\AturanKurikulum;
use App\Models\JenisPenilaian;
use App\Models\KategoriNilai;
use App\Models\Kelas;
use App\Models\Kkm;
use App\Models\MataPelajaran;
use App\Models\Penilaian;
use App\Models\Remidi;
use App\Models\RemidiDetail;
use App\Models\Siswa;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class PrintAnalisisController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia('Guru/PrintAnalisis', [
            'initTahun' => $this->data_tahun(),
            'initSemester' => $this->data_semester(),
            'listMapel' => $this->data_mapel(),
        ]);
    }

    public function print()
    {
        $kelas = Kelas::find(request('kelasId'));

        $kkm = Kkm::whereTahun(request('tahun'))
            ->whereMataPelajaranId(request('mataPelajaranId'))
            ->value('kkm');

        $kurikulum = AturanKurikulum::whereTahun(request('tahun'))
            ->whereTingkat($kelas->tingkat)
            ->with(['kurikulum' => fn ($q) => $q->select('id', 'nama')])
            ->first();

        $listSiswa = Siswa::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'analisisPenilaian' => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereSemester(request('semester'))
                    ->whereMataPelajaranId(request('mataPelajaranId'))
                    ->whereJenisPenilaianId(request('jenisPenilaianId'))
            ])
            ->get();


        $data = [
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'namaMapel' => MataPelajaran::find(request('mataPelajaranId'))
                ->nama,
            'kkm' => $kkm,
            'namaKurikulum' => $kurikulum->kurikulum->nama,
            'listSiswa' => $listSiswa,
            'namaWaliKelas' => $this->data_nama_wali_kelas(),
            'namaKepalaSekolah' => $this->data_nama_kepala_sekolah(),
            'jenisPenilaian' => JenisPenilaian::find(request('jenisPenilaianId'))
                ->nama,
            'namaKelas' => $kelas->nama,
            'listSiswa' => $this->data_siswa_with_analisis_nilai()
        ];

        if (request('kategoriNilaiId') == 3 || request('kategoriNilaiId') == 6) {
            return view('print.guru.print-analisis-pengetahuan', $data);
        } else {
            return view('print.guru.print-analisis-keterampilan', $data);
        }
    }
}
