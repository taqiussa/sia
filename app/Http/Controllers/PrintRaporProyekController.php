<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
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
            'Guru/PrintRapor',
            [
                'initTahun' => $this->data_tahun(),
                'listKelas' => Kelas::orderBy('nama')->get(),
            ]
        );
    }

    public function download()
    {
        $kelas = Kelas::find(request('kelasId'));
        $tahun = request('tahun');
        $nis = request('nis');

        $siswa = Siswa::whereNis($nis)
            ->whereTahun($tahun)
            ->with([
                'penilaianProyek' => fn ($q) => $q->whereTahun($tahun),
                'penilaianProyeks' => fn ($q) => $q->whereTahun($tahun),
            ])
            ->first();

        $listProyek = [];

        $data =
            [
                'listProyek' => $listProyek
            ];

        $pdf = Pdf::loadView('download.rapor-kurtilas', $data)->setPaper(array(0, 0, 609.449, 921.26))->download();

        return response()->streamDownload(
            fn () => print($pdf),
            $siswa->user->name . '.pdf'
        );
    }
}
