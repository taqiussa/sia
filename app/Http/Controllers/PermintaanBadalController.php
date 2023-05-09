<?php

namespace App\Http\Controllers;

use App\Models\Badalan;
use App\Models\User;
use App\Traits\InitTrait;

class PermintaanBadalController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/PermintaanBadal',
            [
                'listGuruBk' => User::role('konseling')
                    ->get(),
                'listGuruAlquran' => User::whereHas('guruMapel.mapel', fn ($q) => $q->whereNama("Al Qur'an"))
                    ->get()
            ]
        );
    }

    public function simpan()
    {
        request()->validate(['badalId' => 'required']);

        Badalan::find(request('id'))
            ->update(['badal_id' => request('badalId')]);

        return to_route('permintaan-badal');
    }
}
