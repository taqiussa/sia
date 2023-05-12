<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;
class DataPengeluaranController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia(
            'Bendahara/DataPengeluaran',
            [
                'initTahun' => $this->data_tahun(),
            ]
        );
    }
}
