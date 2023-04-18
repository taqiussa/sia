<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use App\Traits\InitTrait;
use Illuminate\Http\Request;

class RekapTahunanPengeluaranController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $pengeluaran = Pengeluaran::whereTahun(request('tahun'))
            ->with([
                'kategori' => fn ($q) => $q->select('id', 'nama'),
                'user' => fn ($q) => $q->select('id', 'name')
            ]);

        return inertia(
            'Bendahara/RekapTahunanPengeluaran',
            [
                'initTahun' => $this->data_tahun(),
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
}
