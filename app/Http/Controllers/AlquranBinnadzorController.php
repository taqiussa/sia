<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;
use App\Models\JenisAlquran;
use App\Models\PenilaianAlquran;

class AlquranBinnadzorController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia(
            'Siswa/AlquranBinnadzor',
            [
                'listJenis' => JenisAlquran::whereKategoriAlquranId(2)->get(),
                'listNilai' => PenilaianAlquran::whereNis(auth()->user()->nis)
                    ->whereKategoriAlquranId(2)
                    ->with([
                        'user' => fn ($q) => $q->select('id', 'name')
                    ])
                    ->get()
            ]
        );
    }
}
