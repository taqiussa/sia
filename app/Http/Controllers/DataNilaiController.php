<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;

class DataNilaiController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia('Siswa/DataNilai', [
            'initTahun' => $this->data_tahun(),
            'initSemester' => $this->data_semester()
    ]);
    }
}
