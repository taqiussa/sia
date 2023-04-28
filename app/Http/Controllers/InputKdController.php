<?php

namespace App\Http\Controllers;

use App\Models\JenisPenilaian;
use App\Models\KategoriNilai;
use App\Models\Kd;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class InputKdController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/InputKd',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listKategori' => KategoriNilai::whereIn('id', $this->data_kategori_nilai_per_tingkat())
                    ->orderBy('nama')
                    ->get(),
                'listJenis' => JenisPenilaian::whereIn('id', $this->data_jenis_penilaian())
                    ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->orderBy('nama')
                    ->get(),
                'listMapel' => $this->data_mapel(),
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
            ]
        );
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'mataPelajaranId' => 'required',
            'tingkat' => 'required',
            'kategoriNilaiId' => 'required',
            'jenisPenilaianId' => 'required',
            'deskripsi' => 'required',
        ]);

        Kd::create([
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'mata_pelajaran_id' => request('mataPelajaranId'),
            'tingkat' => request('tingkat'),
            'kategori_nilai_id' => request('kategoriNilaiId'),
            'jenis_penilaian_id' => request('jenisPenilaianId'),
            'deskripsi' => request('deskripsi'),
        ]);
    }

    public function hapus()
    {
        Kd::destroy(request('id'));

        return to_route('input-kd', [
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'mataPelajaranId' => request('mataPelajaranId'),
        ]);
    }
}
