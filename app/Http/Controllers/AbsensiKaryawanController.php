<?php

namespace App\Http\Controllers;

class AbsensiKaryawanController extends Controller
{
    public function index()
    {
        return inertia('Guru/AbsensiKaryawan');
    }
}
