<?php

namespace App\Traits;

use App\Models\Siswa;
use App\Models\RuangUjian;
use App\Models\SiswaEkstra;

trait SiswaTrait
{

    public function data_siswa_with_absensi()
    {
        return Siswa::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'user' => fn ($q) => $q->select('nis', 'name'),
                'absensi' => fn ($q) => $q
                    ->whereTanggal(request('tanggal'))
                    ->whereJam(request('jam')),
                'absensi.guru' => fn ($q) => $q->select('id', 'name'),
            ])
            ->get()
            ->sortBy('user.name')
            ->values();
    }

    public function data_siswa_with_analisis_alquran()
    {
        return Siswa::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'analisisAlqurans' => fn ($q) => $q->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->whereJenisPenilaianId(request('jenisPenilaianId'))
                    ->whereTahun(request('tahun'))
                    ->whereSemester(request('semester')),
                'user' => fn ($q) => $q->select('nis', 'name'),
                'penilaian' => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereSemester(request('semester'))
                    ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->whereJenisPenilaianId(request('jenisPenilaianId'))
                    ->whereMataPelajaranId(12)
            ])
            ->get()
            ->sortBy('user.name');
    }

    public function data_siswa_ekstra()
    {
        return SiswaEkstra::whereTahun(request('tahun'))
            ->whereEkstrakurikulerId(request('ekstrakurikulerId'))
            ->withWhereHas('biodata', fn ($q) => $q->whereJenisKelamin(request('jenisKelamin')))
            ->get()
            ->sortBy(['kelas.nama', 'user.name'])
            ->values();
    }

    public function data_siswa_ekstra_with_absensi()
    {
        return SiswaEkstra::whereTahun(request('tahun'))
            ->whereEkstrakurikulerId(request('ekstrakurikulerId'))
            ->withWhereHas('biodata', fn ($q) => $q->whereJenisKelamin(request('jenisKelamin')))
            ->with([
                'absensi' => fn ($q) => $q->whereTanggal(request('tanggal')),
                'absensi.guru',
                'absensi.kehadiran',
                'kelas' => fn ($q) => $q->select('id', 'nama'),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
            ->get()
            ->sortBy(['kelas.nama', 'user.name'])
            ->values();
    }

    public function data_siswa_ujian_with_absensi()
    {
        return RuangUjian::whereTahun(request('tahun'))
            ->whereSemester($this->data_semester())
            ->whereNamaRuang(request('namaRuang'))
            ->whereNamaUjian(request('namaUjian'))
            ->whereJenisKelamin(request('jenisKelamin'))
            ->with([
                'absensi' => fn ($q) => $q->whereTanggal(request('tanggal'))
                    ->whereJam(request('jam')),
                'absensi.guru' => fn ($q) => $q->select('id', 'name'),
                'kelas' => fn ($q) => $q->select('id', 'nama'),
                'user' => fn ($q) => $q->select('nis', 'name'),
            ])
            ->get()
            ->sortBy(['kelas.nama', 'user.name'])
            ->values();
    }
}
