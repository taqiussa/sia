<?php

namespace App\Http\Controllers;

use App\Models\Kd;
use App\Models\Badalan;
use App\Models\WaliKelas;
use App\Traits\InitTrait;
use App\Models\KategoriNilai;
use App\Models\JenisPenilaian;

class GetDataGuruController extends Controller
{
    use InitTrait;

    public function get_kelas_wali_kelas()
    {
        return response()->json([
            'kelasId' => $this->data_kelas_wali_kelas()
        ]);
    }

    public function get_list_jenis()
    {
        return response()->json([
            'listJenis' => JenisPenilaian::whereIn('id', $this->data_jenis_penilaian())
                ->whereKategoriNilaiId(request('kategoriNilaiId'))
                ->orderBy('nama')
                ->get()
        ]);
    }

    public function get_list_kategori()
    {
        return response()->json([
            'listKategori' => KategoriNilai::whereIn('id', $this->data_kategori_nilai())
                ->orderBy('nama')
                ->get()
        ]);
    }

    public function get_list_kategori_per_tingkat()
    {
        return response()->json([
            'listKategori' => KategoriNilai::whereIn('id', $this->data_kategori_nilai_per_tingkat())
                ->orderBy('nama')
                ->get()
        ]);
    }

    public function get_list_kd()
    {
        return response()->json([
            'listKd' => Kd::whereTahun(request('tahun'))
                ->whereSemester(request('semester'))
                ->whereMataPelajaranId(request('mataPelajaranId'))
                ->with([
                    'jenis' => fn ($q) => $q->select('id', 'nama'),
                    'kategori' => fn ($q) => $q->select('id', 'nama'),
                ])
                ->get()
                ->sortBy(['tingkat', 'kategori.nama', 'jenis.nama'])
                ->values()
        ]);
    }

    public function get_list_kelas_guru()
    {
        return response()->json([
            'listKelas' => $this->data_kelas()
        ]);
    }

    public function get_list_tugas()
    {
        return response()->json([
            'listTugas' => Badalan::whereTanggal(request('tanggal'))
                ->whereUserId(auth()->user()->id)
                ->with([
                    'badal' => fn ($q) => $q->select('id', 'name'),
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'mapel' => fn ($q) => $q->select('id', 'nama'),
                ])
                ->orderBy('jam')
                ->get()
        ]);
    }
}
