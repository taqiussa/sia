<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportRekapHarianPengeluaran;

class RekapHarianPengeluaranController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Bendahara/RekapHarianPengeluaran',
            [
                'initTahun' => $this->data_tahun(),
            ]
        );
    }

    public function download()
    {
        set_time_limit(0);
        return Excel::download(new ExportRekapHarianPengeluaran(request('tanggalAwal'), request('tanggalAkhir')), 'Laporan Harian Pengeluaran.xlsx');
    }
}
