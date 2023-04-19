<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use App\Models\User;
use App\Traits\InitTrait;
use Illuminate\Http\Request;

class RekapPenggajianController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return inertia(
            'Bendahara/RekapPenggajian',
            [
                'initTahun' => $this->data_tahun(),
                'listPenggajian' => User::where('username', '!=', '')
                    ->where('username', '!=', 'administrator')
                    ->with([
                        'penggajian' => fn ($q) => $q->whereTahun(request('tahun'))
                            ->whereBulan(request('bulan'))
                    ])
                    ->orderBy('name')
                    ->paginate(10)
                    ->withQueryString()
                    ->through(fn ($q) => [
                        'id' => $q->id,
                        'name' => $q->name,
                        'penggajian' => $q->penggajian
                    ]),
                'total' => Penggajian::whereTahun(request('tahun'))
                    ->whereBulan(request('bulan'))
                    ->sum('jumlah_terima')
            ]
        );
    }
}
