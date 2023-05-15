<?php

namespace App\Http\Controllers;

use App\Models\JenisSikap;
use App\Models\KategoriSikap;
use App\Models\PenilaianSikap;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;
use EnumKategoriSikap;

class InputNilaiSikapController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia('Guru/InputNilaiSikap', [
            'initTahun' => $this->data_tahun(),
            'initSemester' => $this->data_semester(),
            'listMapel' => $this->data_mapel(),
            'listKategori' => KategoriSikap::whereId(EnumKategoriSikap::PANCASILA)->get(),
            'listJenis' => JenisSikap::whereKategoriSikapId(EnumKategoriSikap::PANCASILA)
                ->orderBy('nama')
                ->get()
        ]);
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'mataPelajaranId' => 'required',
            'kelasId' => 'required',
            'kategoriSikapId' => 'required',
            'jenisSikapId' => 'required'
        ]);

        PenilaianSikap::updateOrCreate(
            ['id' => request('id')],
            [
                'tahun' => request('tahun'),
                'semester' => request('semester'),
                'kelas_id' => request('kelasId'),
                'mata_pelajaran_id' => request('mataPelajaranId'),
                'nis' => request('nis'),
                'kategori_sikap_id' => request('kategoriSikapId'),
                'jenis_sikap_id' => request('jenisSikapId'),
                'nilai' => request('nilai'),
                'user_id' => auth()->user()->id,
            ]
        );

        return response()->json([
            'listSiswa' => $this->data_siswa_with_nilai_sikap(),
            'message' => 'Tersimpan',
            'nis' => request('nis')
        ]);
    }
}
