<?php

namespace App\Http\Controllers;

use App\Models\Sosial;
use App\Models\User;
use App\Traits\GuruTrait;

class GetDataPenilaianKaryawanController extends Controller
{
    use GuruTrait;

    public function get_absensi_sosial()
    {
        return response()->json([
            'listUser' => $this->data_absensi_sosial()
        ]);
    }

    public function get_absensi_sosials()
    {
        return response()->json([
            'listUser' => $this->data_absensi_sosials()
        ]);
    }

    public function get_list_sosial()
    {
        return response()->json([
            'listSosial' => Sosial::whereTahun(request('tahun'))
                ->get()
        ]);
    }
}
