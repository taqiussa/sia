<?php

namespace App\Http\Controllers;

use App\Models\JenisSikap;
use App\Models\Kelas;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;
use App\Models\MataPelajaran;
use EnumKategoriSikap;

class PrintNilaiSikapController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/PrintNilaiSikap',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listMapel' => $this->data_mapel(),
                'listKelas' => $this->data_kelas(),
            ]
        );
    }

    public function print()
    {
        $namaMapel = MataPelajaran::find(request('mataPelajaranId'))
            ->nama;

        $kelas = Kelas::find(request('kelasId'));

        $data = [
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'namaKelas' => $kelas->nama,
            'namaMapel' => $namaMapel,
            'namaWaliKelas' => $this->data_nama_wali_kelas(),
            'listSiswa' => $this->data_siswa_with_penilaian_sikaps(),
            'listJenis' => JenisSikap::whereKategoriSikapId(EnumKategoriSikap::PANCASILA)
                ->get(),
        ];

        return view('print.guru.print-nilai-sikap', $data);
    }
}
