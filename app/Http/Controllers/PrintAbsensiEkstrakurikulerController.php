<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;
use Barryvdh\DomPDF\Facade\Pdf;

class PrintAbsensiEkstrakurikulerController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/PrintAbsensiEkstrakurikuler',
            [
                'initTahun' => $this->data_tahun(),
                'listEkstrakurikuler' => Ekstrakurikuler::orderBy('nama')->get(),
                'listSiswa' => $this->data_siswa_ekstra_with_absensi()
            ]
        );
    }

    public function download()
    {
        $namaEkstrakurikuler = Ekstrakurikuler::find(request('ekstrakurikulerId'))->nama;

        $data = [
            'namaEkstrakurikuler' => $namaEkstrakurikuler,
            'tahun' => request('tahun'),
            'tanggal' => request('tanggal'),
            'semester' => $this->data_semester(),
            'listSiswa' => $this->data_siswa_ekstra_with_absensi()
        ];

        $pdf = Pdf::loadView('print.guru.print-absensi-ekstrakurikuler', $data)->setPaper(array(0, 0, 595.276, 935.433))->download();

        return response()->streamDownload(
            fn () => print($pdf),
            'Rekap Absensi ' . $namaEkstrakurikuler . ' - ' . tanggal(request('tanggal')) . '.pdf'
        );
    }
}
