<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;
use Illuminate\Http\Request;

class SaldoSkorController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return inertia(
            'Guru/SaldoSkor',
            [
                'initTahun' => $this->data_tahun(),
                'listKelas' => Kelas::orderBy('nama')->get(),
                'listSiswa' => $this->data_siswa_with_skors()
            ]
        );
    }
}
