<?php

namespace App\Http\Controllers;

use App\Models\Badalan;

class ListBadalController extends Controller
{
    public function index()
    {
        return inertia(
            'Guru/ListBadal',
            [
                'listBadalan' => Badalan::whereTanggal(date('Y-m-d'))
                    ->with(['user', 'badal', 'mapel', 'kelas'])
                    ->orderBy('jam')
                    ->get()
            ]
        );
    }
}
