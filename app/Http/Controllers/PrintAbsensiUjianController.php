<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
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
                'initTahun' => $this->data_tahun()
            ]
        );
    }

    public function print()
    {
        $kelasId = RuangUjian::whereTahun(request('tahun'))
            ->whereSemester($this->data_semester())
            ->whereJenisKelamin(request('jenisKelamin'))
            ->groupBy('kelas_id')
            ->pluck('kelas_id');

        $listKelas = Kelas::whereIn('id', $kelasId)
            ->with([
                'absensis' => fn ($q) => $q->whereTanggal(request('tanggal'))
                    ->where('kehadiran_id', '!=', EnumKehadiran::HADIR),
                'absensis.siswa',
                'absensis.kehadiran',
                'ruangUjian' => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereSemester($this->data_semester())
                    ->whereNamaUjian(request('namaUjian'))
            ])
            ->withCount([
                'absensis as total_absensi' => fn ($q) => $q->whereTanggal(request('tanggal')),
                'siswas as total_siswa' => fn ($q) => $q->whereTahun(request('tahun')),
            ])
            ->get();


        $data = [
            'listKelas' => $listKelas,
            'tanggal' => request('tanggal'),
            'namaUjian' => request('namaUjian'),
            'tahun' => request('tahun'),
            'semester' => $this->data_semester(),
            'jam' => request('jam'),
            'jenisKelamin' => request('jenisKelamin')
        ];

        return view('print.guru.print-absensi-ujian', $data);
    }
}
