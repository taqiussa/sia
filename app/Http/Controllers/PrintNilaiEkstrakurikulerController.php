<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\Kelas;
use App\Models\WaliKelas;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class PrintNilaiEkstrakurikulerController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/PrintNilaiEkstrakurikuler',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listKelas' => Kelas::orderBy('nama')->get(),
                'listEkstrakurikuler' => Ekstrakurikuler::orderBy('nama')->get(),
            ]
        );
    }

    public function per_ekstrakurikuler()
    {
        $data = [
            'jenisKelamin' => request('jenisKelamin'),
            'listSiswa' => $this->data_siswa_ekstra_with_nilai(),
            'namaEkstra' => Ekstrakurikuler::find(request('ekstrakurikulerId'))->nama,
            'semester' => request('semester'),
            'tahun' => request('tahun'),
        ];

        return view('print.guru.print-nilai-ekstrakurikuler-per-ekstrakurikuler', $data);
    }

    public function per_kelas()
    {
        $data = [
            'namaKelas' => Kelas::find(request('kelasId'))->nama,
            'namaWaliKelas' => WaliKelas::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with([
                    'user' => fn ($q) => $q->select('id', 'name')
                ])
                ->first()
                ->user
                ->name,
            'listSiswa' => $this->data_siswa_with_nilai_ekstra(),
            'semester' => request('semester'),
            'tahun' => request('tahun'),
        ];

        return view('print.guru.print-nilai-ekstrakurikuler-per-kelas', $data);
    }
}
