<?php

namespace App\Http\Controllers;

use App\Models\JenisPenilaian;
use App\Models\KategoriNilai;
use App\Models\Penilaian;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class InputNilaiController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/InputNilai',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listMapel' => $this->data_mapel(),
                'listKelas' => $this->data_kelas(),
                'listKategori' => KategoriNilai::whereIn('id', $this->data_kategori_nilai())
                    ->orderBy('nama')
                    ->get(),
                'listJenis' => JenisPenilaian::whereIn('id', $this->data_jenis_penilaian())
                    ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->orderBy('nama')
                    ->get()
            ]
        );
    }

    public function simpan()
    {
        request()->validate(['jenisPenilaianId' => 'required'], ['jenisPenilaianId.required' => 'Pilih Jenis Penilaian']);

        Penilaian::updateOrCreate(
            ['id' => request('id')],
            [
                'tanggal' => date('Y-m-d'),
                'nis' => request('nis'),
                'tahun' => request('tahun'),
                'semester' => request('semester'),
                'kelas_id' => request('kelasId'),
                'mata_pelajaran_id' => request('mataPelajaranId'),
                'kategori_nilai_id' => request('kategoriNilaiId'),
                'jenis_penilaian_id' => request('jenisPenilaianId'),
                'nilai' => request('nilai'),
                'user_id' => auth()->user()->id
            ]
        );

        return response()->json([
            'listSiswa' => $this->data_siswa_with_nilai(),
            'message' => 'Tersimpan',
            'nis' => request('nis')
        ]);
    }
}
