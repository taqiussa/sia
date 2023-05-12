<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;

class DataPembayaranSiswaController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {

        return inertia(
            'Bendahara/DataPembayaranSiswa',
            [
                'initTahun' => $this->data_tahun(),
            ]
        );
    }
}
