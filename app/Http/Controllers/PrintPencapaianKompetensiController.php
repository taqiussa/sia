<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;
use App\Models\MataPelajaran;
use App\Models\JenisPenilaian;
use App\Models\KategoriNilai;
use App\Models\PenilaianRapor;

class PrintPencapaianKompetensiController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/PrintPencapaianKompetensi',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listMapel' => $this->data_mapel(),
            ]
        );
    }

    public function print()
    {
        $namaMapel = MataPelajaran::find(request('mataPelajaranId'))
            ->nama;

        $kelas = Kelas::find(request('kelasId'));

        $data = [
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'namaKelas' => $kelas->nama,
            'namaMapel' => $namaMapel,
            'namaKategori' => KategoriNilai::find(request('kategoriNilaiId'))->nama,
            'namaKepalaSekolah' => $this->data_nama_kepala_sekolah(),
            'namaWaliKelas' => $this->data_nama_wali_kelas(),
            'listSiswa' => $this->data_siswa_with_penilaians(),
            'listJenis' => JenisPenilaian::whereIn('id', $this->data_jenis_penilaian())
                ->whereKategoriNilaiId(request('kategoriNilaiId'))
                ->orderBy('kategori_nilai_id')
                ->get(),
        ];

        return view('print.guru.print-pencapaian-kompetensi', $data);
    }
}
