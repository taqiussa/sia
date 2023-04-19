<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Traits\InitTrait;
use Illuminate\Http\Request;

class RekapPerSiswaController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return inertia(
            'Bendahara/RekapPerSiswa',
            [
                'initTahun' => $this->data_tahun(),
                'listKelas' => Kelas::orderBy('nama')->get(),
                'listSiswa' => Siswa::whereTahun(request('tahun'))
                    ->whereKelasId(request('kelasId'))
                    ->with([
                        'user' => fn ($q) => $q->select('nis', 'name')
                    ])
                    ->get()
                    ->sortBy('user.name')
                    ->values()
            ]
        );
    }
}
