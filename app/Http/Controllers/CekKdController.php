<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;

class CekKdController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia('Guru/CekKd', [
            'initTahun' => $this->data_tahun(),
        ]);
    }
}
