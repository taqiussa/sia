<?php

namespace App\Http\Controllers;

use App\Models\Dimensi;
use App\Models\Elemen;

class AturNamaElemenController extends Controller
{
    public function index()
    {
        return inertia(
            'Guru/AturNamaElemen',
            [
                'listDimensi' => Dimensi::orderBy('nama')->get(),
                'listElemen' => Elemen::with('dimensi')->orderBy('nama')->get()
            ]
        );
    }

    public function simpan()
    {
        request()->validate([
            'dimensiId' => 'required',
            'nama' => 'required'
        ]);

        Elemen::create([
            'nama' => request('nama'),
            'dimensi_id' => request('dimensiId')
        ]);

        return to_route('atur-nama-elemen');
    }

    public function hapus()
    {
        request()->validate(['id' => 'required']);

        Elemen::destroy(request('id'));

        return to_route('atur-nama-elemen');
    }
}
