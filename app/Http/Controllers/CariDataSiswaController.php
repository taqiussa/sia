<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;
use App\Traits\SiswaTrait;
use Illuminate\Http\Request;

class CariDataSiswaController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return inertia('Guru/CariDataSiswa', [
            'initTahun' => $this->data_tahun(),
            'listSiswa' => $this->data_all_siswa_with_biodata(),
            'filters' => request()->only('search')
        ]);
    }
}
