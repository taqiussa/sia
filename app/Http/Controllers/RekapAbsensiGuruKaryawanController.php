<?php

namespace App\Http\Controllers;

class RekapAbsensiGuruKaryawanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        return inertia('Guru/RekapAbsensiGuruKaryawan');
    }
}
