<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\GuruTrait;
use App\Traits\InitTrait;

class RekapIbadahController extends Controller
{
    use InitTrait;
    use GuruTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia(
            'Guru/RekapIbadah',
            [
                'initTahun' => $this->data_tahun(),
                'listUser' => $this->data_absensi_ibadahs()
            ]
        );
    }
}
