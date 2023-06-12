<?php

namespace App\Http\Controllers;

use App\Models\Kd;
use App\Models\KurikulumMapel;

class GetDataKdController extends Controller
{
    public function get_kd_per_tingkat()
    {
        return response()->json([
            'listKd' => Kd::whereTahun(request('tahun'))
                ->whereTingkat(request('tingkat'))
                ->with(['jenis'])
                ->get(),
            'listMapel' => KurikulumMapel::whereTahun(request('tahun'))
                ->whereTingkat(request('tingkat'))
                ->with([
                    'mapel' => fn ($q) => $q->select('id', 'nama'),
                ])
                ->get()
        ]);
    }
}
