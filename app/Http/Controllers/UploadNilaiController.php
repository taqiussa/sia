<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;
use App\Exports\ExportNilai;
use App\Imports\ImportNilai;
use App\Models\KategoriNilai;
use App\Models\MataPelajaran;
use App\Models\JenisPenilaian;
use Maatwebsite\Excel\Facades\Excel;

class UploadNilaiController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/UploadNilai',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listKelas' => $this->data_kelas(),
                'listMapel' => $this->data_mapel(),
                'listKategori' => KategoriNilai::whereIn('id', $this->data_kategori_nilai())->orderBy('nama')->get(),
                'listJenis' => JenisPenilaian::whereIn('id', $this->data_jenis_penilaian())
                    ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->orderBy('nama')->get(),
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

        to_route('upload-nilai', [
            'tahun' => request('tahun'),
            'kelasId' => request('kelasId'),
            'semester' => request('semester'),
            'kategoriNilaiId' => request('kategoriNilaiId'),
            'jenisPenilaianId' => request('jenisPenilaianid'),
            'mataPelajaranId' => request('mataPelajaranId')
        ]);
    }
}
