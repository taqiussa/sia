<?php

namespace App\Http\Controllers;

use App\Models\Kd;

class GetDataKdController extends Controller
{
    public function get_kd_per_tingkat()
    {
        return response()->json([
            'listKd' => Kd::whereTahun(request('tahun'))
                ->whereTingkat(request('tingkat'))
                ->get()
        ]);
    }
}
