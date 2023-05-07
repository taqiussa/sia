<?php

namespace App\Http\Controllers;

use App\Models\Catatan;
use App\Models\Kelas;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class InputCatatanRaporController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/InputCatatanRapor',
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
            'catatan' => 'required'
        ]);

        Catatan::create([
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'nis' => request('nis'),
            'catatan' => request('catatan'),
            'kelas_id' => request('kelasId'),
        ]);

        return to_route('input-catatan-rapor');
    }

    public function hapus()
    {
        Catatan::destroy(request('id'));

        return to_route('input-catatan-rapor');
    }
}
