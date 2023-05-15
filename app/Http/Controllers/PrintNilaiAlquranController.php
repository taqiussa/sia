<?php

namespace App\Http\Controllers;

use App\Models\GuruKelas;
use App\Models\JenisAlquran;
use App\Models\Kelas;
use App\Models\KepalaSekolah;
use App\Models\Siswa;
use App\Models\User;
use App\Models\WaliKelas;
use App\Traits\InitTrait;
use EnumKategoriAlquran;

class PrintNilaiAlquranController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/PrintNilaiAlquran',
            [
                'initTahun' => $this->data_tahun(),
            ]
        );
    }

    public function bilghoib()
    {
    }

    public function bilghoib_horizontal()
    {
        $bilghoib = JenisAlquran::whereKategoriAlquranId(EnumKategoriAlquran::BILGHOIB)
            ->get();

        $kelas = Kelas::find(request('kelasId'));

        $kepalaSekolah = KepalaSekolah::whereTahun(request('tahun'))
            ->with(['user' => fn ($q) => $q->select('id', 'name')])
            ->first();

        $namaGuru = GuruKelas::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'user' => fn ($q) => $q->select('id', 'name')
            ])
            ->withWhereHas('mapel', fn ($q) => $q->whereNama("Al Qur'an"))
            ->get();

        $siswa = Siswa::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'penilaianAlqurans' => fn ($q) => $q->whereKategoriAlquranId(EnumKategoriAlquran::BILGHOIB),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
            ->withCount([
                'penilaianAlqurans as hitung' => fn ($q) => $q->whereKategoriAlquranId(EnumKategoriAlquran::BILGHOIB)
            ])
            ->get()
            ->sortBy('user.name')
            ->values();

        $waliKelas = WaliKelas::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with(['user' => fn ($q) => $q->select('id', 'name')])
            ->first();


        $data = [
            'kepalaSekolah' => $kepalaSekolah->user->name,
            'listJenis' => $bilghoib,
            'listSiswa' => $siswa,
            'namaGuru' => $namaGuru,
            'namaKelas' => $kelas->nama,
            'namaWaliKelas' => $waliKelas->user->name,
            'tahun' => request('tahun'),
            'tingkat' => $kelas->tingkat
        ];
        return view('print.guru.print-nilai-alquran-bilghoib-horizontal', $data);
    }

    public function bilghoib_per_siswa()
    {
        $bilghoib = JenisAlquran::whereKategoriAlquranId(EnumKategoriAlquran::BILGHOIB)
            ->get();

        $namaGuru = GuruKelas::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'mapel',
                'user' => fn ($q) => $q->select('id', 'name')
            ])
            ->withWhereHas('mapel', fn ($q) => $q->whereNama("Al Qur'an"))
            ->get();

        $siswa = Siswa::whereTahun(request('tahun'))
            ->whereNis(request('nis'))
            ->with([
                'kelas' => fn ($q) => $q->select('id', 'nama'),
                'penilaianAlqurans' => fn ($q) => $q->whereKategoriAlquranId(EnumKategoriAlquran::BILGHOIB),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
            ->first();

        $data = [
            'siswa' => $siswa,
            'listJenis' => $bilghoib,
            'namaGuru' => $namaGuru,
            'tahun' => request('tahun')
        ];

        return view('print.guru.print-nilai-alquran-bilghoib-per-siswa', $data);
    }

    public function binnadzor()
    {
    }

    public function binnadzor_horizontal()
    {
        $binnadzor = JenisAlquran::whereKategoriAlquranId(EnumKategoriAlquran::BINNADZOR)
            ->get();

        $kelas = Kelas::find(request('kelasId'));

        $kepalaSekolah = KepalaSekolah::whereTahun(request('tahun'))
            ->with(['user' => fn ($q) => $q->select('id', 'name')])
            ->first();

        $namaGuru = GuruKelas::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'user' => fn ($q) => $q->select('id', 'name')
            ])
            ->withWhereHas('mapel', fn ($q) => $q->whereNama("Al Qur'an"))
            ->get();

        $siswa = Siswa::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'penilaianAlqurans' => fn ($q) => $q->whereKategoriAlquranId(EnumKategoriAlquran::BINNADZOR),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
            ->withCount([
                'penilaianAlqurans as hitung' => fn ($q) => $q->whereKategoriAlquranId(EnumKategoriAlquran::BINNADZOR)
            ])
            ->get()
            ->sortBy('user.name')
            ->values();

        $waliKelas = WaliKelas::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with(['user' => fn ($q) => $q->select('id', 'name')])
            ->first();


        $data = [
            'kepalaSekolah' => $kepalaSekolah->user->name,
            'listJenis' => $binnadzor,
            'listSiswa' => $siswa,
            'namaGuru' => $namaGuru,
            'namaKelas' => $kelas->nama,
            'namaWaliKelas' => $waliKelas->user->name,
            'tahun' => request('tahun'),
            'tingkat' => $kelas->tingkat
        ];
        return view('print.guru.print-nilai-alquran-binnadzor-horizontal', $data);
    }

    public function binnadzor_per_siswa()
    {
        $binnadzor = JenisAlquran::whereKategoriAlquranId(EnumKategoriAlquran::BINNADZOR)
            ->get();

        $namaGuru = GuruKelas::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'mapel',
                'user' => fn ($q) => $q->select('id', 'name')
            ])
            ->withWhereHas('mapel', fn ($q) => $q->whereNama("Al Qur'an"))
            ->get();

        $siswa = Siswa::whereTahun(request('tahun'))
            ->whereNis(request('nis'))
            ->with([
                'kelas' => fn ($q) => $q->select('id', 'nama'),
                'penilaianAlqurans' => fn ($q) => $q->whereKategoriAlquranId(EnumKategoriAlquran::BINNADZOR),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
            ->first();

        $data = [
            'siswa' => $siswa,
            'listJenis' => $binnadzor,
            'namaGuru' => $namaGuru,
            'tahun' => request('tahun')
        ];

        return view('print.guru.print-nilai-alquran-binnadzor-per-siswa', $data);
    }
}
