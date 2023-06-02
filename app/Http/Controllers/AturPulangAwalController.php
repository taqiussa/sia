<?php

namespace App\Http\Controllers;

use App\Models\AturanPulangAwal;

class AturPulangAwalController extends Controller
{
    public function index()
    {
        return inertia('Guru/AturPulangAwal');
    }

    public function simpan()
    {
        request()->validate([
            'tanggal' => 'required',
            'jam' => 'required',
        ]);

        if (request('pilihan') == 'Masuk') {
            AturanPulangAwal::create([
                'tanggal' => request('tanggal'),
                'masuk' => request('jam'),
                'pulang' => null
            ]);
        }

        AturanPulangAwal::create([
            'tanggal' => request('tanggal'),
            'pulang' => request('jam'),
            'masuk' => null
        ]);
    }

    public function hapus()
    {
        AturanPulangAwal::destroy(request('id'));
    }
}
