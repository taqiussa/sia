<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\PenilaianRaporPts;
use App\Models\Siswa;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class PrintRaporPtsController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/PrintRaporPts',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listKelas' => Kelas::orderBy('nama')->get(),
            ]
        );
    }

    public function download()
    {
        $tahun = request('tahun');
        $semester = request('semester');
        $kelas = Kelas::find(request('kelasId'));
        $nis = request('nis');

        $siswa = Siswa::whereNis($nis)
            ->with([
                'penilaians' => fn ($q) => $q->whereTahun($tahun)
                    ->whereSemester($semester),
                'user'
            ])
            ->first();

        $data = [
            'listJenis' => PenilaianRaporPts::whereTahun($tahun)
                ->whereSemester($semester)
                ->whereTingkat($kelas->tingkat)
                ->with('jenis')
                ->orderBy('jenis_penilaian_id')
                ->get(),
            'namaKelas' => $kelas->nama,
            'namaSiswa' => $siswa->user->name,
            'nis' => $nis,
            'tahun' => $tahun,
            'semester' => $semester,
            'penilaians' => $siswa->penilaians,
            'kelompok_a' => $this->get_list_mapel($kelas->tingkat, 'A'),
            'kelompok_b' => $this->get_list_mapel($kelas->tingkat, 'B'),
            'kelompok_c' => $this->get_list_mapel($kelas->tingkat, 'C'),
            'namaWaliKelas' => $this->data_nama_wali_kelas(),
        ];

        return view('download.rapor-pts', $data);
    }
}
