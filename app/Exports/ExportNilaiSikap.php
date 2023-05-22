<?php

namespace App\Exports;

use App\Models\JenisSikap;
use App\Traits\SiswaTrait;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportNilaiSikap implements FromView
{
    use SiswaTrait;

    public function view(): View
    {
        $data = [
            'listSiswa' => $this->data_siswa_with_nilai_sikap(),
            'listJenis' => JenisSikap::whereKategoriSikapId(request('kategoriSikapId'))->get(),
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'kelasId' => request('kelasId'),
            'kategoriSikapId' => request('kategoriSikapId'),
            'jenisSikapId' => request('jenisSikapId'),
            'mataPelajaranId' => request('mataPelajaranId'),
        ];
        return view('export.guru.export-nilai-sikap', $data);
    }
}
