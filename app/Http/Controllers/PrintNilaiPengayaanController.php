<?php

namespace App\Http\Controllers;

use App\Models\Kkm;
use App\Models\Kelas;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;
use App\Models\KategoriNilai;
use App\Models\JenisPenilaian;
use App\Models\AturanKurikulum;

class PrintNilaiPengayaanController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/PrintNilaiPengayaan',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listMapel' => $this->data_mapel(),
                'listKelas' => $this->data_kelas(),
                'listKategori' => KategoriNilai::whereIn('id', $this->data_kategori_nilai())
                    ->get(),
                'listJenis' => JenisPenilaian::whereIn('id', $this->data_jenis_penilaian())
                    ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->orderBy('nama')
                    ->get()
            ]
        );
    }

    public function print()
    {
        $kelas = Kelas::find(request('kelasId'));

        $kkm = Kkm::whereTahun(request('tahun'))
            ->whereMataPelajaranId(request('mataPelajaranId'))
            ->value('kkm');

        $kurikulum = AturanKurikulum::whereTahun(request('tahun'))
            ->whereTingkat($kelas->tingkat)
            ->with(['kurikulum' => fn ($q) => $q->select('id', 'nama')])
            ->first();

        $data = [
            'namaKurikulum' => $kurikulum->kurikulum->nama,
        ];

        return view('print.guru.print-nilai-pengayaan', $data);
    }
}
