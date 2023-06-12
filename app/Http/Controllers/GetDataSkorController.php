<?php

namespace App\Http\Controllers;

use App\Models\PenilaianSkor;

class GetDataSkorController extends Controller
{
    public function get_skor_kelas()
    {
        return response()->json([
            'listData' => PenilaianSkor::whereTanggal(request('tanggal'))
                ->whereKelasId(request('kelasId'))
                ->with([
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'siswa' => fn ($q) => $q->select('nis', 'name'),
                    'skors' => fn ($q) => $q->select('id', 'keterangan', 'skor'),
                    'user' => fn ($q) => $q->select('id', 'name'),
                ])
                ->get()
        ]);
    }

    public function get_skor_siswa()
    {
        return response()->json([
            'listData' => PenilaianSkor::whereTanggal(request('tanggal'))
                ->whereNis(request('nis'))
                ->with([
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'siswa' => fn ($q) => $q->select('nis', 'name'),
                    'skors' => fn ($q) => $q->select('id', 'keterangan', 'skor'),
                    'user' => fn ($q) => $q->select('id', 'name'),
                ])
                ->get()
        ]);
    }

    public function get_skor_siswa_per_guru()
    {
        return response()->json([
            'listData' => PenilaianSkor::whereNis(request('nis'))
                ->whereTahun(request('tahun'))
                // ->whereUserId(auth()->user()->id)
                ->with([
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'siswa' => fn ($q) => $q->select('nis', 'name'),
                    'skors' => fn ($q) => $q->select('id', 'keterangan', 'skor'),
                    'user' => fn ($q) => $q->select('id', 'name'),
                ])
                ->get()
        ]);
    }

    public function get_siswa_with_skor_wali_kelas()
    {
        return response()->json([
            'listData' => PenilaianSkor::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with([
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'siswa' => fn ($q) => $q->select('nis', 'name'),
                    'skors' => fn ($q) => $q->select('id', 'keterangan', 'skor'),
                    'user' => fn ($q) => $q->select('id', 'name')
                ])
                ->latest()
                ->get()
        ]);
    }
}
