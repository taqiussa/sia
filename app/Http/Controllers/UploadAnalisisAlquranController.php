<?php

namespace App\Http\Controllers;

use App\Exports\ExportAnalisisAlquran;
use App\Imports\ImportAnalisisAlquran;
use App\Models\GuruKelas;
use App\Models\JenisPenilaian;
use App\Models\KategoriNilai;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Siswa;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;
use Maatwebsite\Excel\Facades\Excel;

class UploadAnalisisAlquranController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/UploadAnalisisAlquran',
            [
                'initSemester' => $this->data_semester(),
                'initTahun' => $this->data_tahun(),
                'listJenis' => JenisPenilaian::whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->whereIn('id', $this->data_jenis_penilaian())
                    ->orderBy('nama')
                    ->get(),
                'listKategori' => KategoriNilai::whereIn('id', $this->data_kategori_nilai())
                    ->get(),
                'listKelas' => GuruKelas::whereTahun(request('tahun'))
                    ->whereGuruId(auth()->user()->id)
                    ->with(['kelas' => fn ($q) => $q->select('id', 'nama'),])
                    ->get(),
                'listSiswa' => $this->data_siswa_with_analisis_alquran()->values(),
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

        to_route('upload-analisis-alquran', [
            'tahun' => request('tahun'),
            'kelasId' => request('kelasId'),
            'semester' => request('semester'),
            'kategoriNilaiId' => request('kategoriNilaiId'),
            'jenisPenilaianId' => request('jenisPenilaianid'),
            'jenisAnalisis' => request('jenisAnalisis')
        ]);
    }
}
