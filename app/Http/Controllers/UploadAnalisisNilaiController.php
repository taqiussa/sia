<?php

namespace App\Http\Controllers;

use App\Exports\ExportAnalisisNilai;
use App\Imports\ImportAnalisisNilai;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;
use App\Models\KategoriNilai;
use App\Models\JenisPenilaian;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use Maatwebsite\Excel\Facades\Excel;

class UploadAnalisisNilaiController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/UploadAnalisisNilai',
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

        return Excel::download(new ExportAnalisisNilai(), $namaKelas . ' Analisis ' . $namaJenis . ' - ' . $namaMapel . '.xlsx');
    }

    public function upload()
    {
        request()->validate(['fileUpload' => 'required|mimes:xls,xlsx']);

        set_time_limit(0);

        Excel::import(new ImportAnalisisNilai(), request('fileUpload'));

        to_route('upload-analisis-nilai', [
            'tahun' => request('tahun'),
            'kelasId' => request('kelasId'),
            'semester' => request('semester'),
            'kategoriNilaiId' => request('kategoriNilaiId'),
            'jenisPenilaianId' => request('jenisPenilaianid'),
            'mataPelajaranId' => request('mataPelajaranId')
        ]);
    }
}
