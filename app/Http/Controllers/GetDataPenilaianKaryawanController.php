<?php

namespace App\Http\Controllers;

use App\Models\PenilaianGuru;
use App\Models\Sosial;
use App\Models\TugasTim;
use App\Models\User;
use App\Traits\GuruTrait;

class GetDataPenilaianKaryawanController extends Controller
{
    use GuruTrait;

    public function get_absensi_sosial()
    {
        return response()->json([
            'listUser' => $this->data_absensi_sosial()
        ]);
    }

    public function get_absensi_sosials()
    {
        return response()->json([
            'listUser' => $this->data_absensi_sosials()
        ]);
    }

    public function get_karyawan_with_nilai()
    {
        return response()->json([
            'listUser' => PenilaianGuru::whereTahun(request('tahun'))
                ->whereKategoriNilaiId(request('kategoriNilaiId'))
                ->whereJenisPenilaianId(request('jenisPenilaianId'))
                ->whereTimId(auth()->user()->id)
                ->with('user')
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }

    public function get_list_jenis_penilaian_karyawan()
    {
        return response()->json([
            'listJenis' => TugasTim::whereTahun(request('tahun'))
                ->whereUserId(auth()->user()->id)
                ->whereKategoriNilaiId(request('kategoriNilaiId'))
                ->with('jenis')
                ->get()
                ->sortBy('jenis.nama')
                ->values()
        ]);
    }

    public function get_list_kategori_penilaian_karyawan()
    {
        return response()->json([
            'listKategori' => TugasTim::whereTahun(request('tahun'))
                ->whereUserId(auth()->user()->id)
                ->with('kategori')
                ->groupBy('kategori_nilai_id')
                ->selectRaw('kategori_nilai_id')
                ->get()
                ->sortBy('kategori.nama')
                ->values()
        ]);
    }

    public function get_list_sosial()
    {
        return response()->json([
            'listSosial' => Sosial::whereTahun(request('tahun'))
                ->get()
        ]);
    }
}
