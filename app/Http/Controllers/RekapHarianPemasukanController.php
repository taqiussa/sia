<?php

namespace App\Http\Controllers;

use App\Exports\ExportRekapHarianPemasukan;
use App\Models\Pemasukan;
use App\Models\Pembayaran;
use App\Traits\InitTrait;
use Maatwebsite\Excel\Facades\Excel;

class RekapHarianPemasukanController extends Controller
{
    use InitTrait;

    public function index()
    {
        $pembayaran = Pembayaran::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])
            ->with([
                'gunabayar' => fn ($q) => $q->select('id', 'nama'),
                'kelas' => fn ($q) => $q->select('id', 'nama'),
                'siswa' => fn ($q) => $q->select('nis', 'name'),
                'user' => fn ($q) => $q->select('id', 'name'),
            ]);

        return inertia(
            'Bendahara/RekapHarianPemasukan',
            [
                'initTahun' => $this->data_tahun(),
                'listPemasukan' => Pemasukan::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])
                    ->with([
                        'kategori' => fn ($q) => $q->select('id', 'nama'),
                        'user' => fn ($q) => $q->select('id', 'name')
                    ])
                    ->latest()
                    ->get(),
                'listPembayaran' => $pembayaran->paginate(10)
                    ->withQueryString()
                    ->through(fn ($q) => [
                        'id' => $q->id,
                        'tanggal' => $q->tanggal,
                        'siswa' => $q->siswa,
                        'kelas' => $q->kelas,
                        'gunabayar' => $q->gunabayar,
                        'tahun' => $q->tahun,
                        'user' => $q->user,
                        'jumlah' => $q->jumlah
                    ]),
                'subtotalPembayaran' => $pembayaran->sum('jumlah')
            ]
        );
    }

    public function download()
    {
        set_time_limit(0);
        return Excel::download(new ExportRekapHarianPemasukan(request('tanggalAwal'), request('tanggalAkhir')), 'Laporan Harian Pemasukan.xlsx');
    }
}
