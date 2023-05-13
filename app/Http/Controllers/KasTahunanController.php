<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;

class KasTahunanController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia('Bendahara/KasTahunan', [
            'initTahun' => $this->data_tahun()
        ]);
    }
}
