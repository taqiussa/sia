<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use App\Traits\InitTrait;
use Illuminate\Http\Request;

class SlipGajiController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return inertia('SlipGaji', [
            'initTahun' => $this->data_tahun(),
            'penggajian' => Penggajian::whereTahun(request('tahun'))
                ->whereBulan(request('bulan'))
                ->whereUserId(auth()->user()->id)
                ->first()
        ]);
    }
}
