<?php

namespace App\Http\Controllers;

use App\Models\Elemen;

class AturNamaElemenController extends Controller
{
    public function index()
    {
        return inertia(
            'Guru/AturNamaProyek',
            [
                'listProyek' => Elemen::orderBy('nama')->get()
            ]
        );
    }

    public function simpan()
    {
        $validate = request()->validate(['nama' => 'required']);

        Elemen::create($validate);

        return to_route('atur-nama-proyek');
    }

    public function hapus()
    {
        request()->validate(['id' => 'required']);

        Elemen::destroy(request('id'));

        return to_route('atur-nama-proyek');
    }
}
