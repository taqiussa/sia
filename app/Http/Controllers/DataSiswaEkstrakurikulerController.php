<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;

class DataSiswaEkstrakurikulerController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia(
            'Guru/DataSiswaEkstrakurikuler',
            [
                'initTahun' => $this->data_tahun(),
            ]
        );
    }
}
