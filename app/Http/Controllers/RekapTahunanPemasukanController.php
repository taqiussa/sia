<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;

class RekapTahunanPemasukanController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia(
            'Bendahara/RekapTahunanPemasukan',
            [
                'initTahun' => $this->data_tahun(),
                'listPemasukan' => $pemasukan->paginate(10)
                    ->withQueryString()
                    ->through(fn ($q) => [
                        'id' => $q->id,
                        'tanggal' => $q->tanggal,
                        'kategori' => $q->kategori,
                        'keterangan' => $q->keterangan,
                        'user' => $q->user,
                        'jumlah' => $q->jumlah
                    ]),
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
                'subtotalPemasukan' => $pemasukan->sum('jumlah'),
                'subtotalPembayaran' => $pembayaran->sum('jumlah')
            ]
        );
    }
}
