<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Traits\InitTrait;
use Illuminate\Http\Request;

class DataPemasukanController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return inertia(
            'Bendahara/DataPemasukan',
            [
                'initTahun' => $this->data_tahun(),
                'listPemasukan' => Pemasukan::when(request('search'), fn ($q) => $q->where('keterangan', 'like', '%' . request('search') . '%'))
                    ->whereTahun(request('tahun'))
                    ->with([
                        'kategori' => fn ($q) => $q->select('id', 'nama'),
                        'user' => fn ($q) => $q->select('id', 'name')
                    ])
                    ->latest()
                    ->paginate(10)
                    ->withQueryString()
                    ->through(fn ($q) => [
                        'id' => $q->id,
                        'jumlah' => $q->jumlah,
                        'kategori' => $q->kategori,
                        'keterangan' => $q->keterangan,
                        'tanggal' => $q->tanggal,
                        'user' => $q->user
                    ]),
                'filters' => request()->only('search')
            ]
        );
    }
}
