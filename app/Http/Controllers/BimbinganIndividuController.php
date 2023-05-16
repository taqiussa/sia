<?php

namespace App\Http\Controllers;

use App\Models\Bk;
use App\Models\Kelas;
use App\Traits\InitTrait;

class BimbinganIndividuController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/BimbinganIndividu',
            [
                'initTahun' => $this->data_tahun(),
                'listKelas' => Kelas::orderBy('nama')->get()
            ]
        );
    }

    public function simpan()
    {
        request()->validate([
            'tanggal' => 'required',
            'jenisBimbingan' => 'required',
            'tahun' => 'required',
            'nis' => 'required',
            'permasalahan' => 'required',
            'penyelesaian' => 'required',
            'tindakLanjut' => 'required',
        ]);

        $bimbingan = Bk::create([
            'tanggal' => request('tanggal'),
            'bentuk_bimbingan' => 'Individu',
            'jenis_bimbingan' => request('jenisBimbingan'),
            'tahun' => request('tahun'),
            'permasalahan' => request('permasalahan'),
            'penyelesaian' => request('penyelesaian'),
            'tindak_lanjut' => request('tindakLanjut'),
            'kelas_id' => request('kelasId'),
            'nis' => request('nis'),
            'user_id' => auth()->user()->id
        ]);

        $imageName = null;
        $imageDokumenName = null;

        if (request()->hasFile('foto')) {
            $image = request()->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(storage_path('app/public/foto'), $imageName);
        }

        if (request()->hasFile('fotoDokumen')) {
            $imageDokumen = request()->file('fotoDokumen');
            $imageDokumenName = time() . '.' . $imageDokumen->getClientOriginalExtension();
            $imageDokumen->move(storage_path('app/public/fotodokumen'), $imageDokumenName);
        }

        $bimbingan->details()->create([
            'tanggal' => request('tanggal'),
            'kelas_id' => request('kelasId'),
            'nis' => request('nis'),
            'foto' => $imageName ? 'foto/' . $imageName : '',
            'foto_dokumen' => $imageDokumenName ? 'fotodokumen/' . $imageDokumenName : '',
            'bentuk_bimbingan' => 'Individu',
            'jenis_bimbingan' => request('jenisBimbingan'),
            'tahun' => request('tahun'),
            'permasalahan' => request('permasalahan'),
            'penyelesaian' => request('penyelesaian'),
            'tindak_lanjut' => request('tindakLanjut'),
            'user_id' => auth()->user()->id
        ]);

        return to_route('bimbingan-individu');
    }
}
