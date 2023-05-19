<?php

namespace App\Http\Controllers;

use App\Models\Elemen;
use App\Models\SubElemen;

class AturNamaSubElemenController extends Controller
{
    public function index()
    {
        return inertia(
            'Guru/AturNamaSubElemen',
            [
                'listElemen' => Elemen::with('dimensi')->orderBy('dimensi_id')->orderBy('nama')->get(),
                'listSubElemen' => SubElemen::with(['elemen', 'elemen.dimensi'])->orderBy('nama')->get()
            ]
        );
    }

    public function simpan()
    {
        request()->validate([
            'elemenId' => 'required',
            'nama' => 'required'
        ]);

        SubElemen::create([
            'nama' => request('nama'),
            'elemen_id' => request('elemenId')
        ]);

        return to_route('atur-nama-sub-elemen');
    }

    public function hapus()
    {
        request()->validate(['id' => 'required']);

        SubElemen::destroy(request('id'));

        return to_route('atur-nama-sub-elemen');
    }
}
