<?php

namespace App\Exports;

use App\Models\AturanProyek;
use App\Traits\SiswaTrait;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportNilaiProyek implements FromView
{
    use SiswaTrait;

    public function view(): View
    {
        $listDimensi = AturanProyek::whereTahun(request('tahun'))
            ->whereProyekId(request('proyekId'))
            ->with('dimensi')
            ->get();

        $data = [
            'listSiswa' => $this->data_siswa_with_penilaian_proyeks(),
            'listDimensi' => $listDimensi,
            'tahun' => request('tahun'),
            'proyekId' => request('proyekId'),
            'kelasId' => request('kelasId'),
        ];
        return view('export.guru.export-nilai-proyek', $data);
    }
}
