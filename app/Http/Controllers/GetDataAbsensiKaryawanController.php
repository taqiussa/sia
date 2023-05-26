<?php

namespace App\Http\Controllers;

use App\Models\AbsensiKaryawan;

class GetDataAbsensiKaryawanController extends Controller
{
    public function get_rekap_absensi_karyawan()
    {
        return response()->json([
            'listAbsensi' => AbsensiKaryawan::whereYear('tanggal', request('tahun'))
                ->whereMonth('tanggal', request('bulan'))
                ->whereUserId(auth()->user()->id)
                ->get()
        ]);
    }
}
