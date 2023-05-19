<?php

namespace App\Http\Controllers;

use App\Models\Dimensi;

class AturNamaDimensiController extends Controller
{
    public function index()
    {
        return inertia(
            'Guru/AturNamaDimensi',
            [
                'listDimensi' => Dimensi::orderBy('nama')->get()
            ]
        );
    }

    public function simpan()
    {
        $validate = request()->validate(['nama' => 'required']);

        Dimensi::create($validate);

        return to_route('atur-nama-dimensi');
    }

    public function hapus()
    {
        request()->validate(['id' => 'required']);

        Dimensi::destroy(request('id'));

        return to_route('atur-nama-dimensi');
    }
}
