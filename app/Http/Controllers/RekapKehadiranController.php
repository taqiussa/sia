<?php

namespace App\Http\Controllers;

use App\Models\Absensi;

class RekapKehadiranController extends Controller
{
    public function index()
    {
        return inertia('Guru/RekapKehadiran', [
            'listAbsensi' => Absensi::whereTanggal(request('tanggal'))
                ->whereJam(request('jam'))
                ->get()
        ]);
    }

    public function detail()
    {
        return inertia('Guru/RekapKehadiranDetail');
    }

    public function simpan()
    {
    }
}
