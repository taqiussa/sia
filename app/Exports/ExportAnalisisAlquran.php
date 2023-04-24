<?php

namespace App\Exports;

use App\Traits\SiswaTrait;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportAnalisisAlquran implements FromView
{
    use SiswaTrait;

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function view(): View
    {
        $data = [
            'jenisAnalisis' => request('jenisAnalisis'),
            'jenisPenilaianId' => request('jenisPenilaianId'),
            'kategoriNilaiId' => request('kategoriNilaiId'),
            'kelasId' => request('kelasId'),
            'listSiswa' => $this->data_siswa_with_analisis_alquran(),
            'semester' => request('semester'),
            'tahun' => request('tahun'),
        ];
        if (request('jenisAnalisis') == 'Proyek') {
            return view('export.guru.export-analisis-alquran-proyek', $data);
        } else {
            return view('export.guru.export-analisis-alquran-ph', $data);
        }
    }
}
