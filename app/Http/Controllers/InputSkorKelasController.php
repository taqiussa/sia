<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Skor;
use App\Models\Siswa;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;
use App\Models\PenilaianSkor;

class InputSkorKelasController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/InputSkorKelas',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listSkor' => Skor::orderByDesc('skor')->get(),
                'listKelas' => Kelas::orderBy('nama')->get()
            ]
        );
    }

    public function simpan()
    {
        dd(request('arrayInput'));
        // $skor = Skor::find(request('skorId'));

        // $siswa = Siswa::whereNis(request('nis'))
        //     ->whereTahun(request('tahun'))
        //     ->first();

        // PenilaianSkor::create(
        //     [
        //         'tanggal' => request('tanggal'),
        //         'tahun' => request('tahun'),
        //         'semester' => request('semester'),
        //         'nis' => request('nis'),
        //         'kelas_id' => $siswa->kelas_id,
        //         'skor_id' => request('skorId'),
        //         'skor' => $skor->skor,
        //         'user_id' => auth()->user()->id
        //     ]
        // );

        return to_route('input-skor-kelas');
    }

    public function hapus()
    {
        PenilaianSkor::destroy(request('id'));

        return to_route('input-skor-kelas');
    }
}
