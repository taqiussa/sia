<?php

namespace App\Http\Controllers;

use App\Models\Skor;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;
use App\Models\PenilaianSkor;
use App\Models\User;

class InputSkorBirrulWalidainController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {

        $lisData = PenilaianSkor::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'kelas' => fn ($q) => $q->select('id', 'nama'),
                'siswa' => fn ($q) => $q->select('nis', 'name'),
                'skors' => fn ($q) => $q->select('id', 'keterangan', 'skor'),
                'user' => fn ($q) => $q->select('id', 'name')
            ])
            ->latest()
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($q) => [
                'id' => $q->id,
                'tanggal' => $q->tanggal,
                'skor' => $q->skor,
                'kelas' => $q->kelas,
                'siswa' => $q->siswa,
                'skors' => $q->skors,
                'user' => $q->user,
            ]);


        return inertia(
            'Guru/InputSkorBirrulWalidain',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listSkor' => Skor::orderByDesc('skor')->get(),
                'listKelas' => Kelas::orderBy('nama')->get(),
                'listData' => $lisData,
                'initKelas' => $this->data_kelas_wali_kelas(),
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

        return to_route(
            'input-skor-birrul-walidain',
            [
                'tahun' => request('tahun'),
                'kelasId' => request('kelasId'),
            ]
        );
    }

    public function hapus()
    {
        PenilaianSkor::destroy(request('id'));

        return to_route(
            'input-skor-birrul-walidain',
            [
                'tahun' => request('tahun'),
                'kelasId' => request('kelasId')
            ]
        );
    }
}
