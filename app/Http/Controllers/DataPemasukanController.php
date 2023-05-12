<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;

class DataPemasukanController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia(
            'Bendahara/DataPemasukan',
            [
                'initTahun' => $this->data_tahun(),
            ]
        );
    }
}
