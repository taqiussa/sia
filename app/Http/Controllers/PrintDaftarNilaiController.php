<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;
use App\Models\MataPelajaran;
use App\Models\JenisPenilaian;
use App\Models\PenilaianRapor;

class PrintDaftarNilaiController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/PrintDaftarNilai',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listMapel' => $this->data_mapel(),
                'listKelas' => $this->data_kelas(),
            ]
        );
    }

    public function print()
    {
        $namaMapel = MataPelajaran::find(request('mataPelajaranId'))
            ->nama;

        $kelas = Kelas::find(request('kelasId'));

        $kategoriId = PenilaianRapor::whereTahun(request('tahun'))
            ->whereTingkat($kelas->tingkat)
            ->pluck('kategori_nilai_id');


        $data = [
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'namaKelas' => $kelas->nama,
            'namaMapel' => $namaMapel,
            'namaWaliKelas' => $this->data_nama_wali_kelas(),
            'listSiswa' => $this->data_siswa_with_penilaians(),
            'listJenis' => JenisPenilaian::whereIn('id', $this->data_jenis_penilaian())
                ->whereIn('kategori_nilai_id', $kategoriId)
                ->orderBy('kategori_nilai_id')
                ->get(),
        ];

        return view('print.guru.print-daftar-nilai', $data);
    }
}
