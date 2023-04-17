<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Traits\InitTrait;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class RekapTahunanPemasukanController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $pemasukan = Pemasukan::whereTahun(request('tahun'))
            ->with([
                'kategori' => fn ($q) => $q->select('id', 'nama'),
                'user' => fn ($q) => $q->select('id', 'name')
            ]);

        $pembayaran = Pembayaran::whereTahun(request('tahun'))
            ->with([
                'gunabayar' => fn ($q) => $q->select('id', 'nama'),
                'kelas' => fn ($q) => $q->select('id', 'nama'),
                'siswa' => fn ($q) => $q->select('nis', 'name'),
                'user' => fn ($q) => $q->select('id', 'name'),
            ]);

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
