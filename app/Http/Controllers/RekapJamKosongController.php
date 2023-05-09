<?php

namespace App\Http\Controllers;

use App\Models\JamKosong;
use App\Traits\InitTrait;
use Illuminate\Http\Request;

class RekapJamKosongController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return inertia(
            'Guru/RekapJamKosong',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listJamKosong' => JamKosong::whereTahun(request('tahun'))
                    ->whereSemester(request('semester'))
                    ->whereHari(request('hari'))
                    ->whereJam(request('jam'))
                    ->with([
                        'user' => fn ($q) => $q->select('id', 'name')
                    ])
                    ->get()
                    ->sortBy('user.name')
                    ->values()
            ]
        );
    }
}
