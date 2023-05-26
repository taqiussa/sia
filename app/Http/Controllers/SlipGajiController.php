<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;
class SlipGajiController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia('Guru/SlipGaji', [
            'initTahun' => $this->data_tahun(),
        ]);
    }
}
