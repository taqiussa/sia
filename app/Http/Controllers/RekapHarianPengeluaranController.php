<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportRekapHarianPemasukan;
use App\Exports\ExportRekapHarianPengeluaran;
use App\Models\Pengeluaran;

class RekapHarianPengeluaranController extends Controller
{
    use InitTrait;

    public function index()
    {
        $pengeluaran = Pengeluaran::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])
            ->with([
                'kategori' => fn ($q) => $q->select('id', 'nama'),
                'user' => fn ($q) => $q->select('id', 'name'),
            ]);

        return inertia(
            'Bendahara/RekapHarianPengeluaran',
            [
                'listPengeluaran' => $pengeluaran->paginate(10)
                    ->withQueryString()
                    ->through(fn ($q) => [
                        'id' => $q->id,
                        'tanggal' => $q->tanggal,
                        'kategori' => $q->kategori,
                        'keterangan' => $q->keterangan,
                        'tanggal_nota' => $q->tanggal_nota,
                        'user' => $q->user,
                        'jumlah' => $q->jumlah
                    ]),
                'total' => $pengeluaran->sum('jumlah')
            ]
        );
    }

    public function download()
    {
        set_time_limit(0);
        return Excel::download(new ExportRekapHarianPengeluaran(request('tanggalAwal'), request('tanggalAkhir')), 'Laporan Harian Pengeluaran.xlsx');
    }
}
