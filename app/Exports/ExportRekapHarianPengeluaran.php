<?php

namespace App\Exports;

use App\Models\Pengeluaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportRekapHarianPengeluaran implements FromView
{
    public function view(): View
    {
        $pengeluaran = Pengeluaran::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])->get();
        $data = [
            'tanggalAwal' => request('tanggalAwal'),
            'tanggalAkhir' => request('tanggalAkhir'),
            'listPengeluaran' => $pengeluaran,
            'total' => $pengeluaran->sum('jumlah'),
        ];

        return view('export.bendahara.rekap-harian-pengeluaran', $data);
    }
}
