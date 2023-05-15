<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;

class RekapTahunanPemasukanController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia(
            'Bendahara/RekapTahunanPemasukan',
            [
                'initTahun' => $this->data_tahun(),
            ]
        );
    }
}
