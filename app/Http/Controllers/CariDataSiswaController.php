<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;

class CariDataSiswaController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia('Guru/CariDataSiswa', [
            'initTahun' => $this->data_tahun(),
        ]);
    }
}
