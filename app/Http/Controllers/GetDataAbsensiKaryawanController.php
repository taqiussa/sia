<?php

namespace App\Http\Controllers;

use App\Models\AbsensiKaryawan;
use App\Models\AturanPulangAwal;

class GetDataAbsensiKaryawanController extends Controller
{
    public function get_list_aturan_pulang_awal()
    {
        return response()->json([
            'listAturan' => AturanPulangAwal::whereTahun(request('tahun'))
                ->get()
        ]);
    }

    public function get_rekap_absensi_karyawan()
    {
        return response()->json([
            'listAbsensi' => AbsensiKaryawan::whereYear('tanggal', request('tahun'))
                ->whereMonth('tanggal', request('bulan'))
                ->whereUserId(auth()->user()->id)
                ->get()
        ]);
    }

    public function get_absensi_harian_karyawan()
    {
        return response()->json([
            'listAbsensi' => AbsensiKaryawan::whereTanggal(request('tanggal'))
                ->with([
                    'user'
                ])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }
}
