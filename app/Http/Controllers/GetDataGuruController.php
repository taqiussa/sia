<?php

namespace App\Http\Controllers;

use App\Models\WaliKelas;

class GetDataGuruController extends Controller
{
    public function get_kelas_wali_kelas()
    {
        return response()->json([
            'kelasId' => WaliKelas::whereTahun(request('tahun'))
                ->whereUserId(auth()->user()->id)
                ->value('kelas_id') ?? ''
        ]);
    }
}
