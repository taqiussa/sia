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

        $listSiswa = request('arrayInput');

        foreach ($listSiswa as $siswa) {
            $siswa['penilaian'] ?
                PenilaianEkstrakurikuler::updateOrCreate(
                    ['id' => $siswa['penilaian']['id'] ?? null],
                    [
                        'tahun' => request('tahun'),
                        'semester' => request('semester'),
                        'ekstrakurikuler_id' => request('ekstrakurikulerId'),
                        'nis' => $siswa['nis'],
                        'kelas_id' => $siswa['kelas_id'],
                        'nilai' => $siswa['penilaian']['nilai'] ?? null,
                        'user_id' => auth()->user()->id
                    ]
                )
                :
                null;
        }

        return to_route('input-nilai-ekstrakurikuler');
    }

    public function hapus()
    {
        PenilaianEkstrakurikuler::destroy(request('id'));

        return to_route('input-nilai-ekstrakurikuler');
    }
}
