<?php

namespace App\Http\Controllers;

use App\Models\AturanProyek;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TanggalRapor;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;
use Barryvdh\DomPDF\Facade\Pdf;


class PrintRaporProyekController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/PrintRaporProyek',
            [
                'initTahun' => $this->data_tahun(),
                'listKelas' => Kelas::orderBy('nama')->get(),
            ]
        );
    }

    public function download()
    {
        $tahun = request('tahun');
        $nis = request('nis');

        $siswa = Siswa::whereNis($nis)
            ->whereTahun($tahun)
            ->with([
                'biodata',
                'kelas',
                'penilaianProyeks' => fn ($q) => $q->whereTahun($tahun),
                'user'
            ])
            ->first();

        $listProyek = AturanProyek::whereTahun($tahun)
            ->with([
                'dimensi',
                'elemen',
                'proyek',
                'subElemen'
            ])
            ->get();

        $data =
            [
                'listProyek' => $listProyek,
                'penilaian' => $siswa->penilaianProyeks,
                'namaSiswa' => $siswa->user?->name,
                'namaKelas' => $siswa->kelas?->nama,
                'nis' => $nis,
                'nisn' => $siswa->biodata->nisn,
                'tahun' => $tahun,
                'tanggalRapor' => TanggalRapor::whereTahun($tahun)->whereSemester(2)->first(),
                'namaWaliKelas' => $this->data_nama_wali_kelas(),
                'namaKepalaSekolah' => $this->data_nama_kepala_sekolah()
            ];

        $pdf = Pdf::loadView('download.rapor-proyek', $data)->setPaper(array(0, 0, 609.449, 921.26))->download();

        return response()->streamDownload(
            fn () => print($pdf),
            $siswa->user->name . '.pdf'
        );
    }
}
