<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;
use Illuminate\Http\Request;

class DataPembayaranSiswaController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return inertia('Bendahara/DataPembayaranSiswa', [
            'initTahun' => $this->data_tahun()
        ]);
    }
}
