<?php

namespace App\Http\Controllers;

use App\Models\AturanProyek;
use App\Models\Dimensi;
use App\Models\Proyek;
use App\Traits\InitTrait;

class AturPenilaianProyekController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia('Guru/AturPenilaianProyek', [
            'initTahun' => $this->data_tahun(),
            'listProyek' => Proyek::orderBy('nama')->get(),
            'listDimensi' => Dimensi::orderBy('nama')->get()
        ]);
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'proyekId' => 'required',
            'dimensiId' => 'required',
            'elemenId' => 'required',
            'subElemenId' => 'required',
            'judul' => 'required',
            'capaian' => 'required',
            'deskripsi' => 'required'
        ]);

        AturanProyek::create([
            'tahun' => request('tahun'),
            'proyek_id' => request('proyekId'),
            'dimensi_id' => request('dimensiId'),
            'elemen_id' => request('elemenId'),
            'sub_elemen_id' => request('subElemenId'),
            'judul' => request('judul'),
            'capaian' => request('capaian'),
            'deskripsi' => request('deskripsi'),
        ]);

        return to_route('atur-penilaian-proyek');
    }

    public function hapus()
    {
        request()->validate(['id' => 'required']);

        AturanProyek::destroy(request('id'));

        return to_route('atur-penilaian-proyek');
    }
}
