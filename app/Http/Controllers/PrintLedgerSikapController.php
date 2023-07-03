<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class PrintLedgerSikapController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/PrintLedgerSikap',
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

        $data = [
            'namaKelas' => $kelas->nama,
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'namaWaliKelas' => $this->data_nama_wali_kelas(),
            'listSiswa' => $this->data_siswa_with_penilaian_sikap_wali_kelas(),
            'listMapel' => $this->data_mapel_rapor($kelas->tingkat),
            'totalMapel' => $this->total_mapel($kelas->tingkat),
        ];

        return view('print.guru.print-ledger-sikap', $data);
    }


    // public function download()
    // {
    //     $namaKelas = Kelas::find(request('kelasId'))->nama;

    //     return Excel::download(new ExportLedgerRapor(), 'Ledger ' . $namaKelas . '.xlsx');
    // }
}
