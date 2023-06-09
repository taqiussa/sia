<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;

class AdministrasiController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia(
            'Siswa/Administrasi',
            [
                'initTahun' => $this->data_tahun()
            ]
        );
    }
}
