<?php

namespace App\Http\Controllers;

use App\Models\Skor;
use App\Models\Kelas;
use App\Traits\InitTrait;
use App\Models\PenilaianSkor;

class InputSkorBirrulWalidainController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/InputSkorBirrulWalidain',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listSkor' => Skor::orderByDesc('skor')->get(),
                'listKelas' => Kelas::orderBy('nama')->get(),
            ]
        );
    }

    public function simpan()
    {
        request()->validate([
            'tanggal' => 'required',
            'tahun' => 'required',
            'semester' => 'required',
            'nis' => 'required',
            'skorId' => 'required',
            'kelasId' => 'required',
        ]);

        $skor = Skor::find(request('skorId'));

        $jumlah = $skor->skor * request('jumlah');

        PenilaianSkor::create(
            [
                'tanggal' => request('tanggal'),
                'tahun' => request('tahun'),
                'semester' => request('semester'),
                'nis' => request('nis'),
                'kelas_id' => request('kelasId'),
                'skor_id' => request('skorId'),
                'skor' => $jumlah,
                'user_id' => auth()->user()->id
            ]
        );

        return to_route('input-skor-birrul-walidain');
    }

    public function hapus()
    {
        PenilaianSkor::destroy(request('id'));

        return to_route('input-skor-birrul-walidain');
    }
}
