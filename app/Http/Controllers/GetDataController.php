<?php

namespace App\Http\Controllers;

use App\Models\Siswa;

class GetDataController extends Controller
{
    public function get_all_siswa()
    {
        return response()->json([
            'listSiswa' => Siswa::whereTahun(request('tahun'))
                ->with([
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'user' => fn ($q) => $q->select('nis', 'name')
                ])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }

    public function get_siswa()
    {
        return response()->json([
            'listSiswa' => Siswa::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with(['user' => fn ($q) => $q->select('nis', 'name')])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }

    public function get_siswa_with_catatan()
    {
        return response()->json([
            'listCatatan' => Siswa::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with([
                    'catatan'  => fn ($q) => $q->whereTahun(request('tahun'))
                        ->whereSemester(request('semester')),
                    'user' => fn ($q) => $q->select('nis', 'name')
                ])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }
}
