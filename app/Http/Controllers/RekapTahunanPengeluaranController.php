<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;

class RekapTahunanPengeluaranController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {


        return inertia(
            'Bendahara/RekapTahunanPengeluaran',
            [
                'initTahun' => $this->data_tahun(),
            ]
        );
    }
}
