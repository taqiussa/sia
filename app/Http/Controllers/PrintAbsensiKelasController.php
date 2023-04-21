<?php

namespace App\Http\Controllers;

use App\Models\GuruKelas;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\WaliKelas;
use App\Traits\InitTrait;
use EnumKehadiran;

class PrintAbsensiKelasController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/PrintAbsensiKelas',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listKelas' => Kelas::orderBy('nama')->get()
            ]
        );
    }

    public function per_bulan()
    {
        $kelas = Kelas::find(request('kelasId'));
        $waliKelas = WaliKelas::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'user' => fn ($q) => $q->select('id', 'name')
            ])
            ->first();

        $guruBk =  GuruKelas::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'user' => fn ($q) => $q->select('id', 'name'),
                'mapel'
            ])
            ->withWhereHas('mapel', fn ($q) => $q->whereNama('Konseling'))
            ->first();

        $siswa = Siswa::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'absensis' => fn ($q) => $q->whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')]),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
            ->withCount([
                'absensis as total' => fn ($q) => $q->whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')]),
            ])
            ->get()
            ->sortBy('user.name')
            ->values();

        $totalTertinggi = $siswa->max('total');

        $data =
            [
                'guruBk' => $guruBk->user->name,
                'listSiswa' => $siswa,
                'namaKelas' => $kelas->nama,
                'namaWaliKelas' => $waliKelas->user->name,
                'tanggalAwal' => request('tanggalAwal'),
                'tanggalAkhir' => request('tanggalAkhir'),
                'totalTertinggi' => $totalTertinggi
            ];
        return view('print.guru.print-absensi-kelas-per-bulan', $data);
    }

    public function per_semester()
    {
        $kelas = Kelas::find(request('kelasId'));
        $waliKelas = WaliKelas::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'user' => fn ($q) => $q->select('id', 'name')
            ])
            ->first();

        $guruBk =  GuruKelas::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'user' => fn ($q) => $q->select('id', 'name'),
                'mapel'
            ])
            ->withWhereHas('mapel', fn ($q) => $q->whereNama('Konseling'))
            ->first();

        $siswa = Siswa::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'absensis' => fn ($q) => $q->whereSemester(request('semester')),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
            ->withCount([
                'absensis as total' => fn ($q) => $q->whereSemester(request('semester')),
            ])
            ->get()
            ->sortBy('user.name')
            ->values();

        $totalTertinggi = $siswa->max('total');

        $data =
            [
                'guruBk' => $guruBk->user->name,
                'listSiswa' => $siswa,
                'namaKelas' => $kelas->nama,
                'namaWaliKelas' => $waliKelas->user->name,
                'semester' => request('semester'),
                'tahun' => request('tahun'),
                'totalTertinggi' => $totalTertinggi
            ];
        return view('print.guru.print-absensi-kelas-per-semester', $data);
    }
}
