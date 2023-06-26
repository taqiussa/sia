<?php

namespace App\Http\Controllers;

use App\Exports\ExportNilaiKaryawan;
use App\Imports\ImportNilaiKaryawan;
use App\Models\JenisPenilaianGuru;
use App\Models\KategoriPenilaianGuru;
use App\Traits\InitTrait;
use Maatwebsite\Excel\Facades\Excel;

class UploadNilaiKaryawanController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/UploadNilaiKaryawan',
            [
                'initTahun' => $this->data_tahun(),
            ]
        );
    }

    public function download()
    {
        $kategori = KategoriPenilaianGuru::find(request('kategoriNilaiId'))->nama;
        $jenis = JenisPenilaianGuru::find(request('jenisPenilaianId'))->nama;
        return Excel::download(new ExportNilaiKaryawan(), $kategori . ' - ' . $jenis . '.xlsx');
    }

    public function upload()
    {
        request()->validate(['fileUpload' => 'required|mimes:xls,xlsx']);

        set_time_limit(0);

        Excel::import(new ImportNilaiKaryawan(), request('fileUpload'));

        to_route('upload-nilai-karyawan');
    }

}
