<?php

namespace App\Http\Controllers;

class RekapHarianAbsensiKaryawanController extends Controller
{
    public function index()
    {
        return inertia('Guru/RekapHarianAbsensiKaryawan');
    }

    public function simpan()
    {
        
    }
}
