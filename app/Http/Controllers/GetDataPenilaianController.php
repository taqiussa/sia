<?php

namespace App\Http\Controllers;

use App\Models\Kkm;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Remidi;
use App\Models\Pengayaan;
use App\Models\Penilaian;
use App\Traits\InitTrait;
use App\Models\SiswaEkstra;
use App\Models\JenisAlquran;
use App\Models\RemidiDetail;
use App\Models\JenisPenilaian;
use App\Models\KurikulumMapel;

class GetDataPenilaianController extends Controller
{
    use InitTrait;

    public function get_list_jenis_alquran_with_nilai_siswa()
    {
        return response()->json([
            'listJenisAlquran' => JenisAlquran::whereKategoriAlquranId(request('kategoriAlquran'))
                ->with([
                    'penilaian' => fn ($q) => $q->whereNis(request('nis')),
                    'penilaian.user'
                ])
                ->get(),
        ]);
    }

    public function get_penilaian_per_kelas()
    {
        $tingkat = Kelas::find(request('kelasId'))?->tingkat;
        return response()->json([
            'listJenis' => JenisPenilaian::whereIn('id', $this->data_jenis_penilaian())
                ->get(),
            'listMapel' => KurikulumMapel::whereTahun(request('tahun'))
                ->whereTingkat($tingkat)
                ->with([
                    'mapel' => fn ($q) => $q->select('id', 'nama'),
                ])
                ->get(),
            'listPenilaian' => Penilaian::whereTahun(request('tahun'))
                ->whereSemester(request('semester'))
                ->whereKelasId(request('kelasId'))
                ->get(),
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
        $kelas = Kelas::find(request('kelasId'));

        $kkm = Kkm::whereMataPelajaranId(request('mataPelajaranId'))
            ->whereTahun(request('tahun'))
            ->whereTingkat($kelas->tingkat)
            ->value('kkm');

        $nis = Penilaian::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->whereMataPelajaranId(request('mataPelajaranId'))
            ->whereKategoriNilaiId(request('kategoriNilaiId'))
            ->whereJenisPenilaianId(request('jenisPenilaianId'))
            ->whereKelasId(request('kelasId'))
            ->where('nilai', '>=', $kkm)
            ->pluck('nis');

        $nisRemidi = RemidiDetail::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->whereMataPelajaranId(request('mataPelajaranId'))
            ->whereKategoriNilaiId(request('kategoriNilaiId'))
            ->whereJenisPenilaianId(request('jenisPenilaianId'))
            ->whereKelasId(request('kelasId'))
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
                ->whereNotIn('nis', $nisRemidi)
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

    public function get_siswa_remidi()
    {
        $kelas = Kelas::find(request('kelasId'));

        $kkm = Kkm::whereMataPelajaranId(request('mataPelajaranId'))
            ->whereTahun(request('tahun'))
            ->whereTingkat($kelas->tingkat)
            ->value('kkm');

        $nis = Penilaian::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->whereMataPelajaranId(request('mataPelajaranId'))
            ->whereKategoriNilaiId(request('kategoriNilaiId'))
            ->whereJenisPenilaianId(request('jenisPenilaianId'))
            ->whereKelasId(request('kelasId'))
            ->where('nilai', '<', $kkm)
            ->pluck('nis');

        $nisRemidi = RemidiDetail::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->whereMataPelajaranId(request('mataPelajaranId'))
            ->whereKategoriNilaiId(request('kategoriNilaiId'))
            ->whereJenisPenilaianId(request('jenisPenilaianId'))
            ->whereKelasId(request('kelasId'))
            ->pluck('nis');

        return response()->json([
            'kkm' => $kkm,
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

    public function get_siswa_with_nilai_alquran()
    {
        return response()->json([
            'listSiswa' => Siswa::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with([
                    'penilaianAlquran' => fn ($q) => $q->whereJenisAlquranId(request('jenisAlquran')),
                    'penilaianAlquran.user',
                    'user' => fn ($q) => $q->select('nis', 'name')
                ])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }

    public function get_siswa_with_nilai_proyek()
    {
        return response()->json([
            'listSiswa' => Siswa::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with([
                    'penilaianProyek'  => fn ($q) => $q->whereTahun(request('tahun'))
                        ->whereProyekId(request('proyekId'))
                        ->whereDimensiId(request('dimensiId')),
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
