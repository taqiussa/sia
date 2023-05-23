<?php

namespace App\Http\Controllers;

use App\Exports\ExportNilaiProyek;
use App\Imports\ImportNilaiProyek;
use App\Models\Kelas;
use App\Models\Proyek;
use App\Traits\InitTrait;
use Maatwebsite\Excel\Facades\Excel;


class UploadNilaiProyekController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/UploadNilaiProyek',
            [
                'initTahun' => $this->data_tahun(),
                'listKelas' => Kelas::orderBy('nama')->get()
            ]
        );
    }

    public function download()
    {
        $namaKelas = Kelas::find(request('kelasId'))->nama;
        $namaProyek = Proyek::find(request('proyekId'))->nama;

        return Excel::download(new ExportNilaiProyek(), $namaKelas . ' Nilai - ' . $namaProyek . '.xlsx');
    }

    public function upload()
    {
        request()->validate(['fileUpload' => 'required|mimes:xls,xlsx']);

        set_time_limit(0);

        Excel::import(new ImportNilaiProyek(), request('fileUpload'));

        to_route('upload-nilai-proyek');
    }
}
