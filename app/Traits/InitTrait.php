<?php

namespace App\Traits;

use App\Models\Kelas;
use App\Models\GuruKelas;
use App\Models\GuruMapel;
use App\Models\WaliKelas;
use App\Models\KepalaSekolah;
use App\Models\MataPelajaran;
use App\Models\KurikulumMapel;
use App\Models\PenilaianRapor;

trait InitTrait
{

    public function data_jenis_penilaian()
    {
        return PenilaianRapor::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->pluck('jenis_penilaian_id');
    }

    public function data_kategori_nilai()
    {
        $tingkat = Kelas::find(request('kelasId'));

        return PenilaianRapor::whereTahun(request('tahun'))
            ->whereTingkat($tingkat?->tingkat)
            ->pluck('kategori_nilai_id');
    }

    public function data_kategori_nilai_per_tingkat()
    {
        return PenilaianRapor::whereTahun(request('tahun'))
            ->whereTingkat(request('tingkat'))
            ->pluck('kategori_nilai_id');
    }

    public function data_kelas()
    {
        return GuruKelas::whereTahun(request('tahun'))
            ->whereMataPelajaranId(request('mataPelajaranId'))
            ->whereGuruId(auth()->user()->id)
            ->with([
                'kelas' => fn ($q) => $q->select('id', 'nama')
            ])
            ->get()
            ->sortBy('kelas.nama')
            ->values();
    }

    public function data_kelas_wali_kelas()
    {
        return  WaliKelas::whereTahun(request('tahun'))
            ->whereUserId(auth()->user()->id)
            ->value('kelas_id') ?? '';
    }

    public function data_mapel()
    {
        return GuruMapel::whereUserId(auth()->user()->id)
            ->with([
                'mapel' => fn ($q) => $q->select('id', 'nama')
            ])
            ->get();
    }

    public function data_mapel_rapor($tingkat)
    {
        return KurikulumMapel::whereTahun(request('tahun'))
            ->whereTingkat($tingkat)
            ->with([
                'mapel' => fn ($q) => $q->select('id', 'nama'),
                'mapel.kkm' => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereTingkat($tingkat)
            ])
            ->get();
    }

    public function data_nama_kepala_sekolah()
    {
        return KepalaSekolah::whereTahun(request('tahun'))
            ->with(['user' => fn ($q) => $q->select('id', 'name')])
            ->first()
            ?->user
            ->name ?? 'Kepala Sekolah Belum di Pilih';
    }

    public function data_nama_wali_kelas()
    {
        return WaliKelas::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with(['user' => fn ($q) => $q->select('id', 'name')])
            ->first()
            ?->user
            ->name
            ?? 'Belum Ada Wali Kelas';
    }

    public function data_semester()
    {
        $bulanIni = date('m');
        if ($bulanIni <= 6) {
            $semester = 2;
        } else {
            $semester = 1;
        }
        return $semester;
    }

    public function data_tahun()
    {
        $tahunIni = date('Y');
        $bulanIni = date('m');
        if ($bulanIni <= 6) {
            $tahunAjaran = (intval($tahunIni) - 1) . ' / ' . intval($tahunIni);
        } else {
            $tahunAjaran = intval($tahunIni) . ' / ' . (intval($tahunIni) + 1);
        }
        return $tahunAjaran;
    }

    public function data_tahun_baru()
    {
        $tahunIni = date('Y');
        $bulanIni = date('m');
        if ($bulanIni <= 6) {
            $tahunAjaran = intval($tahunIni) . ' / ' . (intval($tahunIni) + 1);
        } else {
            $tahunAjaran = (intval($tahunIni) + 1) . ' / ' . (intval($tahunIni) + 2);
        }
        return $tahunAjaran;
    }

    public function get_list_mapel($tingkat, $kelompok)
    {
        $mataPelajaranId = MataPelajaran::whereKelompok($kelompok)
            ->pluck('id');

        return KurikulumMapel::whereTahun(request('tahun'))
            ->whereTingkat($tingkat)
            ->whereIn('mata_pelajaran_id', $mataPelajaranId)
            ->with([
                'mapel' => fn ($q) => $q->select('id', 'nama')
            ])
            ->get();
    }

    public function total_mapel($tingkat)
    {
        return KurikulumMapel::whereTahun(request('tahun'))
            ->whereTingkat($tingkat)
            ->count();
    }
}
