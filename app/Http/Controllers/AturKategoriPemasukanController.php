<?php

namespace App\Http\Controllers;

use App\Models\KategoriPemasukan;

class AturKategoriPemasukanController extends Controller
{
    public function index()
    {
        return inertia(
            'Bendahara/AturKategoriPemasukan',
            [
                'listKategoriPemasukan' => KategoriPemasukan::orderBy('nama')->get()
            ]
        );
    }

    public function simpan()
    {
        $validated = request()->validate(['nama' => 'required']);

        KategoriPemasukan::create($validated);
        
        return to_route('atur-kategori-pemasukan');
    }

    public function hapus()
    {
        KategoriPemasukan::destroy(request('id'));

        return to_route('atur-kategori-pemasukan');
    }
}
