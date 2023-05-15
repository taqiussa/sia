<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Traits\InitTrait;

class SaldoSkorController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia(
            'Guru/SaldoSkor',
            [
                'initTahun' => $this->data_tahun(),
                'listKelas' => Kelas::orderBy('nama')->get(),
            ]
        );
    }
}
