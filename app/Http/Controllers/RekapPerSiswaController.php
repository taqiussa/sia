<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Traits\InitTrait;

class RekapPerSiswaController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia(
            'Bendahara/RekapPerSiswa',
            [
                'initTahun' => $this->data_tahun(),
                'listKelas' => Kelas::orderBy('nama')->get(),
            ]
        );
    }
}
