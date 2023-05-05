<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Remidi;
use App\Models\Pengayaan;
use App\Models\Penilaian;
use App\Models\SiswaEkstra;
use App\Models\RemidiDetail;

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

    public function get_siswa_pengayaan()
    {
        $nis = Penilaian::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->whereMataPelajaranId(request('mataPelajaranId'))
            ->whereKategoriNilaiId(request('kategoriNilaiId'))
            ->whereJenisPenilaianId(request('jenisPenilaianId'))
            ->whereKelasId(request('kelasId'))
            ->where('nilai', '>', 75)
            ->pluck('nis');

        return response()->json([
            'pengayaan' => Pengayaan::whereTahun(request('tahun'))
                ->whereSemester(request('semester'))
                ->whereMataPelajaranId(request('mataPelajaranId'))
                ->whereKategoriNilaiId(request('kategoriNilaiId'))
                ->whereJenisPenilaianId(request('jenisPenilaianId'))
                ->whereKelasId(request('kelasId'))
                ->first() ?? '',
            'listSiswa' => Siswa::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with([
                    'pengayaan' => fn ($q) => $q->whereTahun(request('tahun'))
                        ->whereSemester(request('semester'))
                        ->whereMataPelajaranId(request('mataPelajaranId'))
                        ->whereKategoriNilaiId(request('kategoriNilaiId'))
                        ->whereKelasId(request('kelasId'))
                        ->whereJenisPenilaianId(request('jenisPenilaianId')),
                    'penilaian'  => fn ($q) => $q->whereTahun(request('tahun'))
                        ->whereSemester(request('semester'))
                        ->whereMataPelajaranId(request('mataPelajaranId'))
                        ->whereKategoriNilaiId(request('kategoriNilaiId'))
                        ->whereKelasId(request('kelasId'))
                        ->whereJenisPenilaianId(request('jenisPenilaianId'))
                        ->whereKelasId(request('kelasId')),
                    'user' => fn ($q) => $q->select('nis', 'name')
                ])
                ->whereIn('nis', $nis)
                // ->withWhereHas('penilaian', fn ($q) => $q->whereTahun(request('tahun'))
                //     ->whereSemester(request('semester'))
                //     ->whereMataPelajaranId(request('mataPelajaranId'))
                //     ->whereKategoriNilaiId(request('kategoriNilaiId'))
                //     ->whereJenisPenilaianId(request('jenisPenilaianId'))
                //     ->whereKelasId(request('kelasId'))
                //     ->where('nilai', '>', 75))
                // ->orWhereHas('pengayaan', fn ($q) => $q->whereTahun(request('tahun'))
                //     ->whereSemester(request('semester'))
                //     ->whereMataPelajaranId(request('mataPelajaranId'))
                //     ->whereKategoriNilaiId(request('kategoriNilaiId'))
                //     ->whereJenisPenilaianId(request('jenisPenilaianId'))
                //     ->whereKelasId(request('kelasId')))
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }

    public function get_siswa_Remidi()
    {
        $nis = Penilaian::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->whereMataPelajaranId(request('mataPelajaranId'))
            ->whereKategoriNilaiId(request('kategoriNilaiId'))
            ->whereJenisPenilaianId(request('jenisPenilaianId'))
            ->whereKelasId(request('kelasId'))
            ->where('nilai', '<', 75)
            ->pluck('nis');

        $nisRemidi = RemidiDetail::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->whereMataPelajaranId(request('mataPelajaranId'))
            ->whereKategoriNilaiId(request('kategoriNilaiId'))
            ->whereJenisPenilaianId(request('jenisPenilaianId'))
            ->whereKelasId(request('kelasId'))
            ->pluck('nis');

        return response()->json([
            'remidi' => Remidi::whereTahun(request('tahun'))
                ->whereSemester(request('semester'))
                ->whereMataPelajaranId(request('mataPelajaranId'))
                ->whereKategoriNilaiId(request('kategoriNilaiId'))
                ->whereJenisPenilaianId(request('jenisPenilaianId'))
                ->whereKelasId(request('kelasId'))
                ->first() ?? '',
            'listSiswa' => Siswa::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with([
                    'remidi' => fn ($q) => $q->whereTahun(request('tahun'))
                        ->whereSemester(request('semester'))
                        ->whereMataPelajaranId(request('mataPelajaranId'))
                        ->whereKategoriNilaiId(request('kategoriNilaiId'))
                        ->whereJenisPenilaianId(request('jenisPenilaianId')),
                    'penilaian'  => fn ($q) => $q->whereTahun(request('tahun'))
                        ->whereSemester(request('semester'))
                        ->whereMataPelajaranId(request('mataPelajaranId'))
                        ->whereKategoriNilaiId(request('kategoriNilaiId'))
                        ->whereJenisPenilaianId(request('jenisPenilaianId'))
                        ->whereKelasId(request('kelasId')),
                    'user' => fn ($q) => $q->select('nis', 'name')
                ])
                ->whereIn('nis', $nis)
                ->orWhereIn('nis', $nisRemidi)
                // ->withWhereHas('penilaian', fn ($q) => $q->whereTahun(request('tahun'))
                //     ->whereSemester(request('semester'))
                //     ->whereMataPelajaranId(request('mataPelajaranId'))
                //     ->whereKategoriNilaiId(request('kategoriNilaiId'))
                //     ->whereJenisPenilaianId(request('jenisPenilaianId'))
                //     ->whereKelasId(request('kelasId'))
                //     ->where('nilai', '<', 75))
                // ->orWhereHas('remidi', fn ($q) => $q->whereTahun(request('tahun'))
                //     ->whereSemester(request('semester'))
                //     ->whereMataPelajaranId(request('mataPelajaranId'))
                //     ->whereKategoriNilaiId(request('kategoriNilaiId'))
                //     ->whereJenisPenilaianId(request('jenisPenilaianId'))
                //     ->whereKelasId(request('kelasId')))
                ->get()
                ->sortBy('user.name')
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

    public function get_siswa_with_nilai()
    {
        return response()->json([
            'listSiswa' => Siswa::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with([
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

    public function get_siswa_with_nilai_sikap()
    {
        return response()->json([
            'listSiswa' => Siswa::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with([
                    'penilaianSikap'  => fn ($q) => $q->whereTahun(request('tahun'))
                        ->whereSemester(request('semester'))
                        ->whereMataPelajaranId(request('mataPelajaranId'))
                        ->whereKategoriSikapId(request('kategoriSikapId'))
                        ->whereJenisSikapId(request('jenisSikapId')),
                    'user' => fn ($q) => $q->select('nis', 'name')
                ])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }
}
