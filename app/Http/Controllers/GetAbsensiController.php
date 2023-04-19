<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Absensi;
use EnumKehadiran;

class GetAbsensiController extends Controller
{
    public function get_absensi_siswa()
    {
        return response()->json([
            'listSiswa' => Siswa::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with([
                    'user' => fn ($q) => $q->select('nis', 'name'),
                    'absensi' => fn ($q) => $q
                        ->whereTanggal(request('tanggal'))
                        ->whereJam(request('jam')),
                    'absensi.guru' => fn ($q) => $q->select('id', 'name'),
                ])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }

    public function get_info_absensi()
    {
        return response()->json([
            'listInfo' => Absensi::whereTanggal(request('tanggal'))
                ->whereKelasId(request('kelasId'))
                ->where('kehadiran_id', '!=', EnumKehadiran::HADIR)
                ->with([
                    'siswa' => fn ($q) => $q->select('nis', 'name'),
                    'kehadiran' => fn ($q) => $q->select('id', 'nama')
                ])
                ->get()
                ->sortBy(['user.name', 'jam'])
                ->values()
        ]);
    }
}
