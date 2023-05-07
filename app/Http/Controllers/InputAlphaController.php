<?php

namespace App\Http\Controllers;

use App\Models\DataAlfa;
use App\Models\Kelas;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class InputAlphaController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/InputAlpha',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listKelas' => Kelas::orderBy('nama')->get(),
            ]
        );
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'kelasId' => 'required',
            'nis' => 'required',
            'jumlah' => 'required|numeric'
        ]);

        DataAlfa::create([
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'nis' => request('nis'),
            'jumlah' => request('jumlah'),
            'kelas_id' => request('kelasId'),
        ]);

        return to_route('input-alpha');
    }

    public function hapus()
    {
        DataAlfa::destroy(request('id'));

        return to_route('input-alpha');
    }
}
