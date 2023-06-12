<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;
use App\Models\PenilaianSkor;

class HapusSkorController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia('Guru/HapusSkor', [
            'initTahun' => $this->data_tahun(),
        ]);
    }

    public function hapus()
    {
        PenilaianSkor::destroy(request('id'));

        return to_route('hapus-skor');
    }
}
