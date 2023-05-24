<?php

namespace App\Http\Controllers;

use App\Models\AbsensiKaryawan;

class AbsensiKaryawanController extends Controller
{
    public function index()
    {
        return inertia(
            'Guru/AbsensiKaryawan',
            [
                'listAbsensi' => AbsensiKaryawan::whereTanggal(date('Y-m-d'))
                    ->with(['user' => fn ($q) => $q->select('id', 'name')])
                    ->latest()
                    ->get()
            ]
        );
    }

    public function simpan()
    {
        AbsensiKaryawan::create([
            'user_id' => request('id'),
            'masuk' => now(),
            'tanggal' => date('Y-m-d')
        ]);

        return to_route('absensi-karyawan');
    }
}
