<?php

namespace App\Http\Controllers;

use App\Exports\ExportLedgerRapor;
use App\Models\Kelas;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;
use App\Models\PenilaianRapor;
use App\Models\AturanKurikulum;
use Maatwebsite\Excel\Facades\Excel;

class PrintLedgerRaporController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/PrintLedgerRapor',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listKelas' => Kelas::orderBy('nama')->get(),
            ]
        );
    }

    public function print()
    {
        $kelas = Kelas::find(request('kelasId'));

        $listJenis = PenilaianRapor::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->whereTingkat($kelas->tingkat)
            ->pluck('jenis_penilaian_id');

        $data = [
            'namaKelas' => $kelas->nama,
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'namaWaliKelas' => $this->data_nama_wali_kelas(),
            'listSiswa' => $this->data_siswa_with_penilaian_rapors(),
            'listMapel' => $this->data_mapel_rapor($kelas->tingkat),
            'totalMapel' => $this->total_mapel($kelas->tingkat),
            'listJenis' => $listJenis
        ];

        $aturanKurikulum =  AturanKurikulum::whereTahun(request('tahun'))
            ->whereTingkat($kelas->tingkat)
            ->first();

        if ($aturanKurikulum->kurikulum_id == 1) {
            return view('print.guru.print-ledger-rapor-kurtilas', $data);
        } else {
            return view('print.guru.print-ledger-rapor-merdeka', $data);
        }
    }

    public function print_ranking()
    {
        $kelas = Kelas::find(request('kelasId'));

        $listJenis = PenilaianRapor::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->whereTingkat($kelas->tingkat)
            ->pluck('jenis_penilaian_id');

        $data = [
            'namaKelas' => $kelas->nama,
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'namaWaliKelas' => $this->data_nama_wali_kelas(),
            'listSiswa' => $this->data_siswa_with_penilaian_rapors(),
            'listMapel' => $this->data_mapel_rapor($kelas->tingkat),
            'totalMapel' => $this->total_mapel($kelas->tingkat),
            'listJenis' => $listJenis
        ];

        $aturanKurikulum =  AturanKurikulum::whereTahun(request('tahun'))
            ->whereTingkat($kelas->tingkat)
            ->first();

        if ($aturanKurikulum->kurikulum_id == 1) {
            return view('print.guru.print-ledger-rapor-ranking-kurtilas', $data);
        } else {
            return view('print.guru.print-ledger-rapor-ranking-merdeka', $data);
        }
    }

    public function download()
    {
        $namaKelas = Kelas::find(request('kelasId'))->nama;

        return Excel::download(new ExportLedgerRapor(), 'Ledger ' . $namaKelas . '.xlsx');
    }
}
