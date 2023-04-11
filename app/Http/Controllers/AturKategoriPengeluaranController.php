<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengeluaran;

class AturKategoriPengeluaranController extends Controller
{
    public function index()
    {
        return inertia('Bendahara/AturKategoriPengeluaran',[
            'listKategoriPengeluaran' => KategoriPengeluaran::orderBy('nama')->get()
        ]);
    }

    public function simpan()
    {
        $validate = request()->validate(['nama' => 'required']);

        KategoriPengeluaran::create($validate);

        return to_route('atur-kategori-pengeluaran');
    }

    public function hapus()
    {
        KategoriPengeluaran::destroy(request('id'));

        return to_route('atur-kategori-pengeluaran');
    }
}
