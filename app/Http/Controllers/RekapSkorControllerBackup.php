<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;
use App\Models\PenilaianSkor;

class RekapSkorControllerBackup extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia('Guru/RekapSkor', ['initTahun' => $this->data_tahun()]);
    }

    public function hapus()
    {
        PenilaianSkor::destroy(request('id'));

        return to_route('rekap-skor');
    }
}
