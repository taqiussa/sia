<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\WajibBayar;
use App\Traits\InitTrait;

class AdministrasiController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $tingkat = Siswa::whereTahun($this->data_tahun())
            ->whereNis(auth()->user()->nis)
            ->value('tingkat');

        return inertia(
            'Siswa/Administrasi',
            [
                'listData' => Pembayaran::whereTahun($this->data_tahun())
                    ->whereNis(auth()->user()->nis)
                    ->with([
                        'gunabayar' => fn ($q) => $q->select('id', 'nama'),
                    ])
                    ->get(),
                'wajibBayar' => WajibBayar::whereTahun($this->data_tahun())
                    ->whereTingkat($tingkat)
                    ->value('jumlah')
            ]
        );
    }
}
