<?php

namespace App\Http\Controllers;

use App\Models\PenilaianSkor;
use App\Models\Siswa;
use App\Models\Skor;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class InputSkorController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/InputSkor',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listSkor' => Skor::orderByDesc('skor')->get(),
            ]
        );
    }

    public function simpan()
    {
        $skor = Skor::find(request('skorId'));

        $siswa = Siswa::whereNis(request('nis'))
            ->whereTahun(request('tahun'))
            ->first();

        PenilaianSkor::create(
            [
                'tanggal' => request('tanggal'),
                'tahun' => request('tahun'),
                'semester' => request('semester'),
                'nis' => request('nis'),
                'kelas_id' => $siswa->kelas_id,
                'skor_id' => request('skorId'),
                'skor' => $skor->skor,
                'user_id' => auth()->user()->id
            ]
        );

        return to_route('input-skor');
    }

    public function hapus()
    {
        PenilaianSkor::destroy(request('id'));

        return to_route('input-skor');
    }
}
