<?php

namespace App\Http\Controllers;

use App\Imports\ImportSiswaNonKelasTujuh;
use App\Imports\ImportUserKelasTujuh;
use Maatwebsite\Excel\Facades\Excel;

class UploadSiswaController extends Controller
{
    public function index()
    {
        return inertia('Guru/UploadSiswa');
    }

    public function siswa_baru()
    {
        request()->validate(['fileUploadKelasTujuh' => 'required|mimes:xls,xlsx']);

        set_time_limit(0);

        Excel::import(new ImportUserKelasTujuh(), request('fileUploadKelasTujuh'));

        to_route('upload-siswa');
    }

    public function siswa_lama()
    {
        request()->validate(['fileUpload' => 'required|mimes:xls,xlsx']);

        set_time_limit(0);

        Excel::import(new ImportSiswaNonKelasTujuh(), request('fileUpload'));

        to_route('upload-siswa');
    }
}
