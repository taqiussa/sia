<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Prestasi;
use App\Models\SiswaEkstra;
use App\Models\Ekstrakurikuler;
use App\Traits\SiswaTrait;

class GetDataController extends Controller
{
    use SiswaTrait;

    public function get_all_siswa()
    {
        return response()->json([
            'listSiswa' => Siswa::whereTahun(request('tahun'))
                ->with([
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'user' => fn ($q) => $q->select('nis', 'name')
                ])
                ->get()
                ->sortBy(['kelas.nama', 'user.name'])
                ->values()
        ]);
    }

    public function get_all_siswa_with_biodata()
    {
        return response()->json([
            'listSiswa' => $this->data_all_siswa_with_biodata()
        ]);
    }

    public function get_all_siswa_belum_ekstra()
    {
        return response()->json([
            'listSiswaBelum' => $this->data_siswa_belum_ekstra()
        ]);
    }

    public function get_all_siswa_ekstra()
    {
        return response()->json([
            'listSiswa' => SiswaEkstra::whereTahun(request('tahun'))
                ->with([
                    'ekstrakurikuler' => fn ($q) => $q->select('id', 'nama'),
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'user' => fn ($q) => $q->select('nis', 'name')
                ])
                ->get()
                ->sortBy(['kelas.nama', 'user.name'])
                ->values()
        ]);
    }

    public function get_list_ekstra()
    {
        return response()->json([
            'listEkstrakurikuler' => Ekstrakurikuler::orderBy('nama')
                ->with([
                    'deskripsi' => fn ($q) => $q->whereTahun(request('tahun'))
                        ->whereSemester(request('semester'))
                ])
                ->get()
        ]);
    }

    public function get_prestasi()
    {
        return response()->json([
            'listPrestasi' => Prestasi::whereTahun(request('tahun'))
                ->whereSemester(request('semester'))
                ->with([
                    'guru' => fn ($q) => $q->select('id', 'name'),
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'user' => fn ($q) => $q->select('nis', 'name')
                ])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }

    public function get_siswa()
    {
        return response()->json([
            'listSiswa' => Siswa::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with(['user' => fn ($q) => $q->select('nis', 'name')])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }

    public function get_siswa_ekstra()
    {
        return response()->json([
            'listSiswa' => $this->data_siswa_ekstra()
        ]);
    }

    public function get_siswa_with_biodata()
    {
        return response()->json([
            'listSiswa' => Siswa::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with([
                    'alamat',
                    'biodata',
                    'orangTua',
                    'user'
                ])
                ->get()
        ]);
    }

    public function get_siswa_with_catatan()
    {
        return response()->json([
            'listCatatan' => Siswa::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with([
                    'catatan'  => fn ($q) => $q->whereTahun(request('tahun'))
                        ->whereSemester(request('semester')),
                    'user' => fn ($q) => $q->select('nis', 'name')
                ])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }

    public function get_siswa_with_skor()
    {
        return response()->json([
            'listSiswa' => $this->data_siswa_with_skors()
        ]);
    }
}
