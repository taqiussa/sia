<?php

namespace App\Http\Controllers;

use App\Exports\ExportAnalisisAlquran;
use App\Imports\ImportAnalisisAlquran;
use App\Models\JenisPenilaian;
use App\Models\Kelas;
use App\Traits\InitTrait;
use Maatwebsite\Excel\Facades\Excel;

class UploadAnalisisAlquranController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/UploadAnalisisAlquran',
            [
                'initSemester' => $this->data_semester(),
                'initTahun' => $this->data_tahun(),
            ]
        );
    }

    public function download()
    {
        $namaJenis = JenisPenilaian::find(request('jenisPenilaianId'))->nama;
        $namaKelas = Kelas::find(request('kelasId'))->nama;
        return Excel::download(new ExportAnalisisAlquran(), 'Analisis Alquran ' . $namaJenis . ' - ' . $namaKelas . '.xlsx');
    }

    public function upload()
    {
        request()->validate(['fileUpload' => 'required|mimes:xls,xlsx']);

        set_time_limit(0);

        Excel::import(new ImportAnalisisAlquran(), request('fileUpload'));

        to_route('upload-analisis-alquran');
    }
}
