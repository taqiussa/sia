<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Traits\InitTrait;
use App\Models\Pembayaran;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use App\Models\KategoriPemasukan;
use App\Models\KategoriPengeluaran;

class KasTahunanController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $pemasukan = KategoriPemasukan::withWhereHas(
            'pemasukan',
            fn ($q) => $q->whereTahun(request('tahun'))
                ->where('jumlah', '>', 0)
        )
            ->get();

        $pengeluaran = KategoriPengeluaran::withWhereHas(
            'pengeluaran',
            fn ($q) => $q->whereTahun(request('tahun'))
                ->where('jumlah', '>', 0)
        )
            ->get();

        $totalSPP = Pembayaran::whereTahun(request('tahun'))
            ->sum('jumlah');

        $totalPemasukan = Pemasukan::whereTahun(request('tahun'))
            ->sum('jumlah') + $totalSPP;

        $totalPengeluaran = Pengeluaran::whereTahun(request('tahun'))
        ->sum('jumlah');

        return inertia('Bendahara/KasTahunan', [
            'initTahun' => $this->data_tahun(),
            'listPemasukan' => $pemasukan,
            'listPengeluaran' => $pengeluaran,
            'saldo' => $totalPemasukan - $totalPengeluaran,
            'totalSPP' => $totalSPP,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran
        ]);
    }
}
