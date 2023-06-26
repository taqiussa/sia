<?php

namespace App\Http\Controllers;

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
}
