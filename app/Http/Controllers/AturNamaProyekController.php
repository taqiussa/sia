<?php

namespace App\Http\Controllers;

use App\Models\Proyek;

class AturNamaProyekController extends Controller
{

    public function index()
    {
        return inertia(
            'Guru/AturNamaProyek',
            [
                'listProyek' => Proyek::orderBy('nama')->get()
            ]
        );
    }

    public function simpan()
    {
        $validate = request()->validate(['nama' => 'required']);

        Proyek::create($validate);

        return to_route('atur-nama-proyek');
    }

    public function hapus()
    {
        request()->validate(['id' => 'required']);

        Proyek::destroy(request('id'));

        return to_route('atur-nama-proyek');
    }
}
