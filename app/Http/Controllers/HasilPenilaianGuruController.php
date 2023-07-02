<?php

namespace App\Http\Controllers;

use App\Models\KategoriPenilaianGuru;
use App\Models\PenilaianRaporGuru;
use App\Traits\InitTrait;

class HasilPenilaianGuruController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia(
            'Guru/HasilPenilaianGuru',
            [
                'initTahun' => $this->data_tahun(),
                'listKategori' =>  KategoriPenilaianGuru::orderBy('nama')->get(),
                'listJenis' => PenilaianRaporGuru::whereTahun(request('tahun'))
                    ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->with('jenis')
                    ->get()
            ]
        );
    }
}
