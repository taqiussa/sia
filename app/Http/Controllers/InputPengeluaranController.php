<?php

namespace App\Http\Controllers;

use App\Models\KategoriPengeluaran;
use App\Models\Pengeluaran;
use App\Traits\InitTrait;

class InputPengeluaranController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia('Bendahara/InputPengeluaran',[
            'initTahun' => $this->data_tahun(),
            'listKategoriPengeluaran' => KategoriPengeluaran::orderBy('nama')->get()
        ]);
    }

    public function simpan()
    {
        request()->validate([
            'tanggal' => 'required',
            'tanggalNota' => 'required',
            'tahun' => 'required',
            'kategoriPengeluaranId' => 'required',
            'keterangan' => 'required',
            'jumlah' => 'required',
        ]);

        Pengeluaran::create([
            'tanggal' => request('tanggal'),
            'tanggal_nota' => request('tanggalNota'),
            'tahun' => request('tahun'),
            'kategori_pengeluaran_id' => request('kategoriPengeluaranId'),
            'keterangan' => request('keterangan'),
            'jumlah' => ambilAngka(request('jumlah')),
            'user_id' => auth()->user()->id
        ]);

        return to_route('input-pengeluaran');
    }

    public function hapus()
    {
        Pengeluaran::destroy(request('id'));

        return to_route(request('route'));
    }
}
