<?php

namespace App\Http\Controllers;

use App\Models\GuruKelas;
use App\Models\JenisAlquran;
use App\Models\KategoriAlquran;
use App\Models\PenilaianAlquran;
use App\Models\Siswa;
use App\Traits\InitTrait;

class InputNilaiAlquranController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/InputNilaiAlquran',
            [
                'initTahun' => $this->data_tahun(),
                'listKategoriAlquran' => KategoriAlquran::orderBy('nama')->get(),
                'listKelas' => GuruKelas::whereTahun(request('tahun'))
                    ->whereGuruId(auth()->user()->id)
                    ->with([
                        'kelas' => fn ($q) => $q->select('id', 'nama'),
                    ])
                    ->get(),
                'listSiswa' => Siswa::whereTahun(request('tahun'))
                    ->whereKelasId(request('kelasId'))
                    ->with([
                        'user' => fn ($q) => $q->select('nis', 'name')
                    ])
                    ->get()
                    ->sortBy('user.name')
                    ->values(),
            ]
        );
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'kelasId' => 'required',
            'nis' => 'required',
            'kategoriAlquran' => 'required',
            'jenisAlquran' => 'required',
            'nilai' => 'required'
        ]);

        PenilaianAlquran::updateOrCreate(
            [
                'nis' => request('nis'),
                'kategori_alquran_id' => request('kategoriAlquran'),
                'jenis_alquran_id' => request('jenisAlquran'),
            ],
            [
                'kelas_id' => request('kelasId'),
                'tahun' => request('tahun'),
                'tanggal' => date('Y-m-d'),
                'nilai' => request('nilai'),
                'user_id' => auth()->user()->id
            ]
        );

        return to_route('input-nilai-alquran',);
    }

    public function semua()
    {
        $jenisBelum = JenisAlquran::whereKategoriAlquranId(request('kategoriAlquran'))
            ->whereDoesntHave('penilaian', fn ($q) => $q->whereNis(request('nis')))
            ->get();

        foreach ($jenisBelum as $jenis) {

            PenilaianAlquran::create([
                'nis' => request('nis'),
                'kategori_alquran_id' => request('kategoriAlquran'),
                'jenis_alquran_id' => $jenis->id,
                'kelas_id' => request('kelasId'),
                'tahun' => request('tahun'),
                'tanggal' => date('Y-m-d'),
                'nilai' => request('nilai'),
                'user_id' => auth()->user()->id
            ]);
        }

        return to_route('input-nilai-alquran',);
    }

    public function hapus()
    {
        PenilaianAlquran::destroy(request('id'));

        return to_route('input-nilai-alquran',);
    }
}
