<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Traits\InitTrait;
use App\Exports\ExportNilai;
use App\Imports\ImportNilai;
use App\Models\KategoriNilai;
use App\Models\MataPelajaran;
use App\Models\JenisPenilaian;
use Maatwebsite\Excel\Facades\Excel;

class UploadNilaiController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/UploadNilai',
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

        return Excel::download(new ExportNilai(), $namaKelas . ' Nilai ' . $namaJenis . ' - ' . $namaMapel . '.xlsx');
    }

    public function upload()
    {
        request()->validate(['fileUpload' => 'required|mimes:xls,xlsx']);

        set_time_limit(0);

        Excel::import(new ImportNilai(), request('fileUpload'));

        to_route('upload-nilai');
    }
}
