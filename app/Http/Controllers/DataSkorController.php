<?php

namespace App\Http\Controllers;

use App\Models\PenilaianSkor;
use App\Traits\InitTrait;

class DataSkorController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia(
            'Siswa/DataSkor',
            [
                'initTahun' => $this->data_tahun()
            ]
        );
    }
}
