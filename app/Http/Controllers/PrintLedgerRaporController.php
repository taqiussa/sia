<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\PenilaianRapor;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class PrintLedgerRaporController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/PrintLedgerRapor',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listKelas' => Kelas::orderBy('nama')->get(),
            ]
        );
    }

    public function print()
    {
        $kelas = Kelas::find(request('kelasId'));

        $listJenis = PenilaianRapor::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->whereTingkat($kelas->tingkat)
            ->pluck('jenis_penilaian_id');

        $data = [
            'namaKelas' => $kelas->nama,
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'namaWaliKelas' => $this->data_nama_wali_kelas(),
            'listSiswa' => $this->data_siswa_with_penilaian_rapors(),
            'listMapel' => $this->data_mapel_rapor($kelas->tingkat),
            'totalMapel' => $this->total_mapel($kelas->tingkat),
            'listJenis' => $listJenis
        ];
        return view('print.guru.print-ledger-rapor', $data);
    }
}
