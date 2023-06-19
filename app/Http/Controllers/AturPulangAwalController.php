<?php

namespace App\Http\Controllers;

use App\Models\AturanPulangAwal;
use App\Traits\InitTrait;

class AturPulangAwalController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia('Guru/AturPulangAwal', ['initTahun' => $this->data_tahun()]);
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'tanggal' => 'required',
            'pilihan' => 'required',
            'jam' => 'required',
        ]);

        if (request('pilihan') == 'Masuk') {
            AturanPulangAwal::create([
                'tanggal' => request('tanggal'),
                'tahun' => request('tahun'),
                'masuk' => request('jam'),
                'keterangan' => request('keterangan')
            ]);
        }

        AturanPulangAwal::create([
            'tanggal' => request('tanggal'),
            'tahun' => request('tahun'),
            'pulang' => request('jam'),
            'keterangan' => request('keterangan')
        ]);

        return to_route('atur-pulang-awal');
    }

    public function hapus()
    {
        AturanPulangAwal::destroy(request('id'));

        return to_route('atur-pulang-awal');
    }
}
