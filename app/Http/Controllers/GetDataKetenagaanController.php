<?php

namespace App\Http\Controllers;

use App\Models\Badalan;

class GetDataKetenagaanController extends Controller
{

    public function get_permintaan_badal()
    {
        return response()->json([
            'listPermintaan' => Badalan::whereTanggal(request('tanggal'))
                ->whereNull('badal_id')
                ->with([
                    'badal' => fn ($q) => $q->select('id', 'name'),
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'mapel' => fn ($q) => $q->select('id', 'nama'),
                    'user' => fn ($q) => $q->select('id', 'name'),
                ])
                ->orderBy('jam')
                ->get()
        ]);
    }
}
