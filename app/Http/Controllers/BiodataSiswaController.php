<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Traits\InitTrait;

class BiodataSiswaController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia('Guru/BiodataSiswa', [
            'initTahun' => $this->data_tahun(),
            'listKelas' => Kelas::orderBy('nama')->get()
        ]);
    }
}
