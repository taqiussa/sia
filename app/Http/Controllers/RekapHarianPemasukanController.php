<?php

namespace App\Http\Controllers;

use App\Exports\ExportRekapHarianPemasukan;
use App\Traits\InitTrait;
use Maatwebsite\Excel\Facades\Excel;

class RekapHarianPemasukanController extends Controller
{
    use InitTrait;

    public function index()
    {

        return inertia(
            'Bendahara/RekapHarianPemasukan',
            [
                'initTahun' => $this->data_tahun(),
            ]
        );
    }

    public function download()
    {
        set_time_limit(0);
        return Excel::download(new ExportRekapHarianPemasukan(request('tanggalAwal'), request('tanggalAkhir')), 'Laporan Harian Pemasukan.xlsx');
    }
}
