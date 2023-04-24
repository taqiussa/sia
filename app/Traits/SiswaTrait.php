<?php

namespace App\Traits;

use App\Models\Siswa;

trait SiswaTrait
{
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
}
