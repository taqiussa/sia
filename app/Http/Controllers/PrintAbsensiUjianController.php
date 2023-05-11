<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Traits\InitTrait;
use App\Models\RuangUjian;
use EnumKehadiran;

class PrintAbsensiUjianController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/PrintAbsensiUjian',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listMapel' => MataPelajaran::orderBy('nama')->get()
            ]
        );
    }

    public function print()
    {
        if (request('jenisKelamin') === 'semua') {
            $kelasId = RuangUjian::whereTahun(request('tahun'))
                ->whereSemester(request('semester'))
                ->groupBy('kelas_id')
                ->pluck('kelas_id');
        } else {
            $kelasId = RuangUjian::whereTahun(request('tahun'))
                ->whereSemester(request('semester'))
                ->whereJenisKelamin(request('jenisKelamin'))
                ->groupBy('kelas_id')
                ->pluck('kelas_id');
        }

        $namaMapel = MataPelajaran::find(request('mataPelajaranId'))->nama;

        $listKelas = Kelas::whereIn('id', $kelasId)
            ->with([
                'absensis' => fn ($q) => $q->whereTanggal(request('tanggal'))
                    ->whereJam(request('jam')),
                'absensis.siswa',
                'absensis.kehadiran',
                'ruangUjian' => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereSemester(request('semester'))
                    ->whereNamaUjian(request('namaUjian'))
            ])
            ->withWhereHas('ruangUjian', fn ($q) => $q->whereTahun(request('tahun'))
                ->whereSemester(request('semester'))
                ->whereNamaUjian(request('namaUjian')))
            ->withCount([
                'siswas as total_siswa' => fn ($q) => $q->whereTahun(request('tahun')),
            ])
            ->get();

        $listRuang = RuangUjian::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->whereNamaUjian(request('namaUjian'))
            ->get();

        $data = [
            'listKelas' => $listKelas,
            'listRuang' => $listRuang,
            'tanggal' => request('tanggal'),
            'namaUjian' => request('namaUjian'),
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'jam' => request('jam'),
            'jenisKelamin' => request('jenisKelamin'),
            'namaMapel' => $namaMapel
        ];

        return view('print.guru.print-absensi-ujian', $data);
    }
}
