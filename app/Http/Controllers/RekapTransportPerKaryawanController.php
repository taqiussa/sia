<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\InitTrait;

class RekapTransportPerKaryawanController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia(
            'Guru/RekapTransportPerKaryawan',
            [
                'initTahun' => $this->data_tahun(),
                'listUser' => User::whereNotNull('username')
                    ->whereIsActive(true)
                    ->orderBy('name')
                    ->get()
            ]
        );
    }
}
