<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\SiswaEkstra;

class GetDataController extends Controller
{
    public function get_all_siswa()
    {
        return response()->json([
            'listSiswa' => Siswa::whereTahun(request('tahun'))
                ->with([
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'user' => fn ($q) => $q->select('nis', 'name')
                ])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }

    public function get_siswa_ekstra_with_nilai()
    {
        return response()->json([
            'listSiswa' => SiswaEkstra::whereTahun(request('tahun'))
                ->whereEkstrakurikulerId(request('ekstrakurikulerId'))
                ->with([
                    'biodata' => fn ($q) => $q->select('nis', 'jenis_kelamin'),
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'penilaian' => fn ($q) => $q->whereTahun(request('tahun'))
                        ->whereSemester(request('semester')),
                    'user' => fn ($q) => $q->select('nis', 'name')
                ])
                ->withWhereHas('biodata', fn ($q) => $q->whereJenisKelamin(request('jenisKelamin')))
                ->get()
                ->sortBy(['kelas.nama', 'user.name'])
                ->values()
        ]);
    }

    public function get_siswa_with_analisis_nilai()
    {
        return response()->json([
            'listSiswa' => Siswa::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with([
                    'analisisPenilaian' => fn ($q) => $q->whereTahun(request('tahun'))
                        ->whereSemester(request('semester'))
                        ->whereMataPelajaranId(request('mataPelajaranId'))
                        ->whereKategoriNilaiId(request('kategoriNilaiId'))
                        ->whereJenisPenilaianId(request('jenisPenilaianId')),
                    'penilaian'  => fn ($q) => $q->whereTahun(request('tahun'))
                        ->whereSemester(request('semester'))
                        ->whereMataPelajaranId(request('mataPelajaranId'))
                        ->whereKategoriNilaiId(request('kategoriNilaiId'))
                        ->whereJenisPenilaianId(request('jenisPenilaianId')),
                    'user' => fn ($q) => $q->select('nis', 'name')
                ])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }
}
