<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use App\Models\Siswa;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class InputPrestasiController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia('Guru/InputPrestasi', [
            'initTahun' => $this->data_tahun(),
            'initSemester' => $this->data_semester(),
            'listSiswa' => $this->data_all_siswa(),
        ]);
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'nis' => 'required',
            'prestasi' => 'required',
            'keterangan' => 'required',
        ]);

        $siswa = Siswa::whereTahun(request('tahun'))
            ->whereNis(request('nis'))
            ->first();

        Prestasi::create([
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'nis' => request('nis'),
            'prestasi' => request('prestasi'),
            'keterangan' => request('keterangan'),
            'kelas_id' => $siswa->kelas_id,
            'user_id' => auth()->user()->id
        ]);

        return to_route('input-prestasi');

    }

    public function hapus()
    {
        Prestasi::destroy(request('id'));

        return to_route('input-prestasi');
    }
}
