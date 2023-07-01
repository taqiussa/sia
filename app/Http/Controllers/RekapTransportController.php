<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;

class RekapTransportController extends Controller
{
    use InitTrait;

    public function __invoke()
    {
        return inertia(
            'Guru/RekapTransport',
            [
                'initTahun' => $this->data_tahun()
            ]
        );
    }
}
