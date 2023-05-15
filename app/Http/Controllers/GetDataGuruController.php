<?php

namespace App\Http\Controllers;

use App\Models\Badalan;
use App\Models\JenisPenilaian;
use App\Models\KategoriNilai;
use App\Models\WaliKelas;
use App\Traits\InitTrait;

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
