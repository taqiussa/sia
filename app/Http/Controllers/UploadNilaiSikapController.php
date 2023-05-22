<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use EnumKategoriSikap;
use App\Traits\InitTrait;
use App\Models\KategoriSikap;
use App\Models\MataPelajaran;
use App\Exports\ExportNilaiSikap;
use App\Imports\ImportNilaiSikap;
use Maatwebsite\Excel\Facades\Excel;

class UploadNilaiSikapController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/UploadNilaiSikap',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listMapel' => $this->data_mapel(),
                'listKategori' => KategoriSikap::whereId(EnumKategoriSikap::PANCASILA)->get(),
            ]
        );
    }

    public function download()
    {
        $namaKelas = Kelas::find(request('kelasId'))->nama;
        $namaMapel = MataPelajaran::find(request('mataPelajaranId'))->nama;

        return Excel::download(new ExportNilaiSikap(), $namaKelas . ' Nilai Sikap  - ' . $namaMapel . '.xlsx');
    }

    public function upload()
    {
        request()->validate(['fileUpload' => 'required|mimes:xls,xlsx']);

        set_time_limit(0);

        Excel::import(new ImportNilaiSikap(), request('fileUpload'));

        to_route('upload-nilai-sikap');
    }
}
