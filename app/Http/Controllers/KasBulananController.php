<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;
class KasBulananController extends Controller
{
    use InitTrait;


    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {


        return inertia(
            'Bendahara/KasBulanan',
            [
                'initTahun' => $this->data_tahun(),
            ]
        );
    }
}
