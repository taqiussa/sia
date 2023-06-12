<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Traits\InitTrait;

class CekPenilaianController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia('Guru/CekPenilaian', [
            'initTahun' => $this->data_tahun(),
            'initSemester' => $this->data_semester(),
            'listKelas' => Kelas::orderBy('nama')->get()
        ]);
    }
}
