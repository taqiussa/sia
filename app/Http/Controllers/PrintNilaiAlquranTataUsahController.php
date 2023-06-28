<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Traits\InitTrait;

class PrintNilaiAlquranTataUsahController extends Controller
{
    use InitTrait;

    public function __invoke()
    {
        return inertia(
            'Guru/PrintNilaiAlquranTataUsaha',
            [
                'initTahun' => $this->data_tahun(),
                'listKelas' => Kelas::orderBy('nama')->get()
            ]
        );
    }
}
