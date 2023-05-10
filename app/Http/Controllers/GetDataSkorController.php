<?php

namespace App\Http\Controllers;

use App\Models\PenilaianSkor;

class GetDataSkorController extends Controller
{
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
}