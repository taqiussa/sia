<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\InitTrait;

class RekapTotalTransportController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $users = User::whereNotNull('username')
            ->whereIsActive(true)
            ->with([
                'rekapTransports' => fn ($q) => $q->whereBulan(request('bulan'))
                    ->whereTahun(request('tahun'))
            ])
            ->withCount([
                'rekapTransports as hitung' => fn ($q) => $q->whereBulan(request('bulan'))
                    ->whereTahun(request('tahun'))
            ])
            ->orderBy('name')
            ->get();

        return inertia(
            'Guru/RekapTotalTransport',
            [
                'initTahun' => $this->data_tahun(),
                'listUser' => $users,
                'maxHadir' => $users->max('hitung')
            ]
        );
    }
}
