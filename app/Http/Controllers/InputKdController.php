<?php

namespace App\Http\Controllers;

use App\Models\Kd;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class InputKdController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/InputKd',
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
                'tahun' => 'required',
                'semester' => 'required',
                'mataPelajaranId' => 'required',
                'tingkat' => 'required',
                'kategoriNilaiId' => 'required',
                'jenisPenilaianId' => 'required',
                'deskripsi' => 'required|string|min:65|max:100',
            ],
            [
                'deskripsi.min' => 'minimal 65 karakter (termasuk spasi)',
                'deskripsi.max' => 'maksimal 100 karakter (termasuk spasi)'
            ]
        );

        Kd::updateOrCreate(
            [
                'tahun' => request('tahun'),
                'semester' => request('semester'),
                'mata_pelajaran_id' => request('mataPelajaranId'),
                'tingkat' => request('tingkat'),
                'kategori_nilai_id' => request('kategoriNilaiId'),
                'jenis_penilaian_id' => request('jenisPenilaianId'),
            ],
            [
                'deskripsi' => request('deskripsi'),
            ]
        );

        return to_route('input-kd');
    }

    public function hapus()
    {
        Kd::destroy(request('id'));

        return to_route('input-kd');
    }
}
