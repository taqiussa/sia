<?php

namespace App\Traits;

use App\Models\Siswa;
use App\Models\RuangUjian;
use App\Models\SiswaEkstra;
use PhpParser\Node\Expr\FuncCall;

trait SiswaTrait
{

    public function data_all_siswa()
    {
        return Siswa::whereTahun(request('tahun'))
            ->with([
                'kelas' => fn ($q) => $q->select('id', 'nama'),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
            ->get()
            ->sortBy('user.name')
            ->values();
    }

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

    public function data_siswa_with_analisis_nilai()
    {
        return  Siswa::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'analisisPenilaian' => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereSemester(request('semester'))
                    ->whereMataPelajaranId(request('mataPelajaranId'))
                    ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->whereJenisPenilaianId(request('jenisPenilaianId'))
                    ->whereKelasId(request('kelasId')),
                'penilaian'  => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereSemester(request('semester'))
                    ->whereMataPelajaranId(request('mataPelajaranId'))
                    ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->whereJenisPenilaianId(request('jenisPenilaianId'))
                    ->whereKelasId(request('kelasId')),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
            ->get()
            ->sortBy('user.name')
            ->values();
    }

    public function data_siswa_with_nilai()
    {
        return Siswa::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'penilaian' => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereSemester(request('semester'))
                    ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->whereJenisPenilaianId(request('jenisPenilaianId'))
                    ->whereMataPelajaranId(request('mataPelajaranId')),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
            ->get()
            ->sortBy('user.name')
            ->values();
    }

    public function data_siswa_with_nilai_ekstra()
    {
        return Siswa::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'penilaianEkstrakurikuler' => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereSemester(request('semester')),
                'penilaianEkstrakurikuler.ekstrakurikuler',
                'user' => fn ($q) => $q->select('nis', 'name'),
            ])
            ->get()
            ->sortBy('user.name')
            ->values();
    }

    public function data_siswa_with_nilai_pengayaan()
    {
        return Siswa::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'pengayaan' => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereSemester(request('semester'))
                    ->whereMataPelajaranId(request('mataPelajaranId'))
                    ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->whereJenisPenilaianId(request('jenisPenilaianId'))
                    ->whereKelasId(request('kelasId')),
                'penilaian'  => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereSemester(request('semester'))
                    ->whereMataPelajaranId(request('mataPelajaranId'))
                    ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->whereJenisPenilaianId(request('jenisPenilaianId'))
                    ->where('nilai', '>', 75),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
            ->withWhereHas('penilaian', fn ($q) => $q->whereTahun(request('tahun'))
                ->whereSemester(request('semester'))
                ->whereMataPelajaranId(request('mataPelajaranId'))
                ->whereKategoriNilaiId(request('kategoriNilaiId'))
                ->whereJenisPenilaianId(request('jenisPenilaianId'))
                ->where('nilai', '>', 75))
            ->orWhereHas('pengayaan', fn ($q) => $q->whereTahun(request('tahun'))
                ->whereSemester(request('semester'))
                ->whereMataPelajaranId(request('mataPelajaranId'))
                ->whereKategoriNilaiId(request('kategoriNilaiId'))
                ->whereJenisPenilaianId(request('jenisPenilaianId'))
                ->whereKelasId(request('kelasId')))
            ->get()
            ->sortBy('user.name')
            ->values();
    }

    public function data_siswa_with_nilai_remidi()
    {
        return Siswa::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'remidi' => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereSemester(request('semester'))
                    ->whereMataPelajaranId(request('mataPelajaranId'))
                    ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->whereJenisPenilaianId(request('jenisPenilaianId'))
                    ->whereKelasId(request('kelasId')),
                'penilaian'  => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereSemester(request('semester'))
                    ->whereMataPelajaranId(request('mataPelajaranId'))
                    ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->whereJenisPenilaianId(request('jenisPenilaianId'))
                    ->where('nilai', '<', 75),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
            ->withWhereHas('penilaian', fn ($q) => $q->whereTahun(request('tahun'))
                ->whereSemester(request('semester'))
                ->whereMataPelajaranId(request('mataPelajaranId'))
                ->whereKategoriNilaiId(request('kategoriNilaiId'))
                ->whereJenisPenilaianId(request('jenisPenilaianId'))
                ->where('nilai', '<', 75))
            ->orWhereHas('remidi', fn ($q) => $q->whereTahun(request('tahun'))
                ->whereSemester(request('semester'))
                ->whereMataPelajaranId(request('mataPelajaranId'))
                ->whereKategoriNilaiId(request('kategoriNilaiId'))
                ->whereJenisPenilaianId(request('jenisPenilaianId'))
                ->whereKelasId(request('kelasId')))
            ->get()
            ->sortBy('user.name')
            ->values();
    }

    public function data_siswa_with_nilai_sikap()
    {
        return Siswa::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'penilaianSikap' => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereSemester(request('semester'))
                    ->whereMataPelajaranId(request('mataPelajaranId'))
                    ->whereKategoriSikapId(request('kategoriSikapId'))
                    ->whereJenisSikapId(request('jenisSikapId')),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
            ->get()
            ->sortBy('user.name')
            ->values();
    }

    public function data_siswa_belum_ekstra()
    {
        return Siswa::whereTahun(request('tahun'))
            ->whereNotIn('tingkat', [9])
            ->with([
                'kelas' => fn ($q) => $q->select('id', 'nama'),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
            ->whereDoesntHave('siswaEkstra', fn ($q) => $q->whereTahun(request('tahun')))
            ->get()
            ->sortBy(['kelas.nama', 'user.name'])
            ->values();
    }

    public function data_siswa_ekstra()
    {
        return SiswaEkstra::whereTahun(request('tahun'))
            ->whereEkstrakurikulerId(request('ekstrakurikulerId'))
            ->with([
                'kelas' => fn ($q) => $q->select('id', 'nama'),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
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
                'absensi.guru' => fn ($q) => $q->select('id', 'name'),
                'absensi.kehadiran' => fn ($q) => $q->select('id', 'nama'),
                'kelas' => fn ($q) => $q->select('id', 'nama'),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
            ->get()
            ->sortBy(['kelas.nama', 'user.name'])
            ->values();
    }

    public function data_siswa_ekstra_with_nilai()
    {
        return SiswaEkstra::whereTahun(request('tahun'))
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
