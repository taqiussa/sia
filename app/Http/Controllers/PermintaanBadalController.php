<?php

namespace App\Http\Controllers;

use App\Models\Badalan;

class PermintaanBadalController extends Controller
{
    public function index()
    {
        return inertia('Guru/PermintaanBadal');
    }
}
