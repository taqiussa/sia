<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\PenilaianProyek;
use App\Models\Proyek;
use App\Traits\InitTrait;

class InputNilaiProyekController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/InputNilaiProyek',
            [
                'initTahun' => $this->data_tahun(),
                'listKelas' => Kelas::orderBy('nama')->get(),
                'listProyek' => Proyek::orderBy('nama')->get(),
            ]
        );
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'proyekId' => 'required',
            'dimensiId' => 'required',
            'kelasId' => 'required',
        ]);

        $listSiswa = request('arrayInput');
        foreach ($listSiswa as $siswa) {
            PenilaianProyek::updateOrCreate(
                [
                    'id' => $siswa['penilaian_proyek']['id'] ?? null
                ],
                [
                    'tahun' => request('tahun'),
                    'proyek_id' => request('proyekId'),
                    'dimensi_id' => request('dimensiId'),
                    'kelas_id' => request('kelasId'),
                    'nis' => $siswa['nis'],
                    'nilai' => $siswa['penilaian_proyek']['nilai'] ?? null,
                ]
            );
        }

        return to_route('input-nilai-proyek');
    }

    public function hapus()
    {
        PenilaianProyek::destroy(request('id'));

        return to_route('input-nilai-proyek');
    }
}
