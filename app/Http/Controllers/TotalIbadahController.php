<?php

namespace App\Http\Controllers;

use App\Traits\GuruTrait;
use App\Traits\InitTrait;

class TotalIbadahController extends Controller
{
    use InitTrait;
    use GuruTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia('Guru/TotalIbadah',
        [
            'initTahun' => $this->data_tahun(),
            'listUser' =>  $this->data_absensi_ibadahs()
        ]);
    }
}
