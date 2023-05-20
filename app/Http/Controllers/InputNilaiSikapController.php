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

        $listSiswa = request('arrayInput');

        foreach ($listSiswa as $siswa) {
            $siswa['penilaian_sikap'] ?
            PenilaianSikap::updateOrCreate(
                ['id' => $siswa['penilaian_sikap']['id'] ?? null],
                [
                    'tahun' => request('tahun'),
                    'semester' => request('semester'),
                    'kelas_id' => request('kelasId'),
                    'mata_pelajaran_id' => request('mataPelajaranId'),
                    'nis' => $siswa['nis'],
                    'kategori_sikap_id' => request('kategoriSikapId'),
                    'jenis_sikap_id' => request('jenisSikapId'),
                    'nilai' => $siswa['penilaian_sikap']['nilai'] ?? null,
                    'user_id' => auth()->user()->id,
                ]
            )
            :
            null;
        }

        return to_route('input-nilai-sikap');
    }

    public function hapus()
    {
        PenilaianSikap::destroy(request('id'));

        return to_route('input-nilai-sikap');
    }
}
