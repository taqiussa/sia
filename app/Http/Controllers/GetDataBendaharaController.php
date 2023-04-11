<?php

namespace App\Http\Controllers;

use App\Models\WajibBayar;
use App\Traits\InitTrait;

class GetDataBendaharaController extends Controller
{
    use InitTrait;

    public function get_wajib_bayar()
    {
        return response()->json([
            'listWajibBayar' => WajibBayar::whereTahun(request('tahun'))
                ->get()
        ]);
    }
}
