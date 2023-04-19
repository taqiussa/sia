<?php

namespace App\Http\Controllers;

use App\Imports\ImportPenggajian;
use Maatwebsite\Excel\Facades\Excel;

class UploadPenggajianController extends Controller
{
    public function index()
    {
        return inertia('Bendahara/UploadPenggajian');
    }

    public function upload()
    {
        Excel::import(new ImportPenggajian(), request()->file('fileUpload'));
        
        return to_route('upload-penggajian');
    }
}
