<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class InputNilaiController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/InputNilai',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listMapel' => $this->data_mapel(),
            ]
        );
    }

    public function simpan()
    {
        request()->validate(
            [
                'jenisPenilaianId' => 'required'
            ],
            [
                'jenisPenilaianId.required' => 'Pilih Jenis Penilaian'
            ]
        );

        $listSiswa = request('arrayInput');

        foreach ($listSiswa as $siswa) {
            Penilaian::updateOrCreate(
                ['id' => $siswa['penilaian']['id'] ?? null],
                [
                    'tanggal' => date('Y-m-d'),
                    'nis' => $siswa['nis'],
                    'tahun' => request('tahun'),
                    'semester' => request('semester'),
                    'kelas_id' => request('kelasId'),
                    'mata_pelajaran_id' => request('mataPelajaranId'),
                    'kategori_nilai_id' => request('kategoriNilaiId'),
                    'jenis_penilaian_id' => request('jenisPenilaianId'),
                    'nilai' => $siswa['penilaian']['nilai'] ?? null,
                    'user_id' => auth()->user()->id
                ]
            );
        }
        return to_route('input-nilai');
    }

    public function hapus()
    {
        Penilaian::destroy(request('id'));

        return to_route('input-nilai');
    }

    public function ganda()
    {
        request()->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'mataPelajaranId' => 'required',
            'kelasId' => 'required',
            'jenisPenilaianId' => 'required'
        ]);

        $nilai = Penilaian::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->whereKelasId(request('kelasId'))
            ->whereMataPelajaranId(request('mataPelajaranId'))
            ->whereJenisPenilaianId(request('jenisPenilaianId'))
            ->groupBy('jenis_penilaian_id', 'nis')
            ->get();

        Penilaian::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->whereKelasId(request('kelasId'))
            ->whereMataPelajaranId(request('mataPelajaranId'))
            ->whereJenisPenilaianId(request('jenisPenilaianId'))
            ->whereNotIn('id', $nilai->pluck('id'))
            ->delete();

        return to_route('input-nilai');
    }
}
