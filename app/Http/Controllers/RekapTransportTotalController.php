<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;

class RekapTransportTotalController extends Controller
{
    use InitTrait;

    public function __invoke()
    {
        return inertia(
            'Guru/RekapTransportTotal',
            [
                'initTahun' => $this->data_tahun(),
            ]
        );
    }
}
