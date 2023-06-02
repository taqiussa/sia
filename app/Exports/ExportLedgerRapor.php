<?php

namespace App\Exports;

use App\Models\Kelas;
use App\Models\PenilaianRapor;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportLedgerRapor implements FromView
{
    use InitTrait;
    use SiswaTrait;
    
    public function view(): View
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

        return view('download.ledger-rapor', $data);
    }
}
