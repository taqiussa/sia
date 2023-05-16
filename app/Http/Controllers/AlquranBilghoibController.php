<?php

namespace App\Http\Controllers;

use App\Models\JenisAlquran;
use App\Models\PenilaianAlquran;
use App\Traits\InitTrait;

class AlquranBilghoibController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia(
            'Siswa/AlquranBilghoib',
            [
                'listJenis' => JenisAlquran::whereKategoriAlquranId(1)->get(),
                'listNilai' => PenilaianAlquran::whereNis(auth()->user()->nis)
                    ->whereKategoriAlquranId(1)
                    ->with([
                        'user' => fn ($q) => $q->select('id', 'name')
                    ])
                    ->get()
            ]
        );
    }
}
