<?php

namespace App\Http\Controllers;

use App\Models\Badalan;
use App\Models\User;

class PermintaanBadalController extends Controller
{
    public function index()
    {
        return inertia(
            'Guru/PermintaanBadal',
            [
                'listUser' => User::whereNotNull('username')
                    ->get()
            ]
        );
    }
}
