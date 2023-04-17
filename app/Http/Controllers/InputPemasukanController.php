<?php

namespace App\Http\Controllers;

use App\Models\KategoriPemasukan;
use App\Models\Pemasukan;
use App\Traits\InitTrait;

class InputPemasukanController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Bendahara/InputPemasukan',
            [
                'initTahun' => $this->data_tahun(),
                'listKategoriPemasukan' => KategoriPemasukan::orderBy('nama')->get()
            ]
        );
    }

    public function simpan()
    {
        request()->validate([
            'tanggal' => 'required',
            'tahun' => 'required',
            'kategoriPemasukanId' => 'required',
            'keterangan' => 'required',
            'jumlah' => 'required',
        ]);

        Pemasukan::create([
            'tanggal' => request('tanggal'),
            'tahun' => request('tahun'),
            'kategori_pemasukan_id' => request('kategoriPemasukanId'),
            'keterangan' => request('keterangan'),
            'jumlah' => ambilAngka(request('jumlah')),
            'user_id' => auth()->user()->id
        ]);

        return to_route('input-pemasukan');
    }

    public function hapus()
    {
        Pemasukan::destroy(request('id'));

        return to_route(request('route'));
    }
}
