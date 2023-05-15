<?php

namespace App\Http\Controllers;

use App\Exports\ExportAnalisisNilai;
use App\Imports\ImportAnalisisNilai;
use App\Traits\InitTrait;
use App\Models\JenisPenilaian;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Maatwebsite\Excel\Facades\Excel;

class UploadAnalisisNilaiController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/UploadAnalisisNilai',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listMapel' => $this->data_mapel(),
            ]
        );
    }

    public function download()
    {
        $namaKelas = Kelas::find(request('kelasId'))->nama;
        $namaMapel = MataPelajaran::find(request('mataPelajaranId'))->nama;
        $namaJenis = JenisPenilaian::find(request('jenisPenilaianId'))->nama;

        return Excel::download(new ExportAnalisisNilai(), $namaKelas . ' Analisis ' . $namaJenis . ' - ' . $namaMapel . '.xlsx');
    }

    public function upload()
    {
        request()->validate(['fileUpload' => 'required|mimes:xls,xlsx']);

        set_time_limit(0);

        Excel::import(new ImportAnalisisNilai(), request('fileUpload'));

        to_route('upload-analisis-nilai');
    }
}
