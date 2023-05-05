<?php

namespace App\Exports;

use App\Traits\SiswaTrait;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportNilai implements FromView
{
    use SiswaTrait;

    public function view(): View
    {
        $data = [
            'listSiswa' => $this->data_siswa_with_nilai(),
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'kelasId' => request('kelasId'),
            'kategoriNilaiId' => request('kategoriNilaiId'),
            'jenisPenilaianId' => request('jenisPenilaianId'),
            'mataPelajaranId' => request('mataPelajaranId'),
        ];
        return view('export.guru.export-nilai', $data);
    }
}
