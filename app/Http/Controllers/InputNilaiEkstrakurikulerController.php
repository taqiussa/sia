<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\PenilaianEkstrakurikuler;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class InputNilaiEkstrakurikulerController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia('Guru/InputNilaiEkstrakurikuler', [
            'initSemester' => $this->data_semester(),
            'initTahun' => $this->data_tahun(),
            'listEkstrakurikuler' => Ekstrakurikuler::orderBy('nama')->get()
        ]);
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'ekstrakurikulerId' => 'required',
        ]);

        PenilaianEkstrakurikuler::updateOrCreate(
            ['id' => request('id')],
            [
                'tahun' => request('tahun'),
                'semester' => request('semester'),
                'ekstrakurikuler_id' => request('ekstrakurikulerId'),
                'nis' => request('nis'),
                'kelas_id' => request('kelasId'),
                'nilai' => request('nilai') ?? null,
                'user_id' => auth()->user()->id
            ]
        );

        return response()->json([
            'listSiswa' => $this->data_siswa_ekstra_with_nilai(),
            'message' => 'Tersimpan',
            'nis' => request('nis')
        ]);
    }
}
