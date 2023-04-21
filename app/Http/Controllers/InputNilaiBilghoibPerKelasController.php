<?php

namespace App\Http\Controllers;

use App\Models\GuruKelas;
use App\Models\JenisAlquran;
use App\Models\PenilaianAlquran;
use App\Models\Siswa;
use App\Traits\InitTrait;
use EnumKategoriAlquran;

class InputNilaiBilghoibPerKelasController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/InputNilaiBilghoibPerKelas',
            [
                'initTahun' => $this->data_tahun(),
                'listJenisAlquran' => JenisAlquran::whereKategoriAlquranId(EnumKategoriAlquran::BILGHOIB)
                    ->get(),
                'listKelas' => GuruKelas::whereTahun(request('tahun'))
                    ->whereGuruId(auth()->user()->id)
                    ->with([
                        'kelas' => fn ($q) => $q->select('id', 'nama'),
                    ])
                    ->get()
                    ->sortBy('kelas.nama')
                    ->values(),
                'listSiswa' => Siswa::whereTahun(request('tahun'))
                    ->whereKelasId(request('kelasId'))
                    ->with([
                        'penilaianAlquran' => fn ($q) => $q->whereJenisAlquranId(request('jenisAlquran')),
                        'penilaianAlquran.user',
                        'user' => fn ($q) => $q->select('nis', 'name')
                    ])
                    ->get()
                    ->sortBy('user.name')
                    ->values()
            ]
        );
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'kelasId' => 'required',
            'jenisAlquran' => 'required',
            'nilai' => 'required',
        ]);

        $siswaBelum = Siswa::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->whereDoesntHave('penilaianAlquran', fn ($q) => $q->whereJenisAlquranId(request('jenisAlquran')))
            ->get();

        foreach ($siswaBelum as $siswa) {
            PenilaianAlquran::create(
                [
                    'tanggal' => date('Y-m-d'),
                    'nis' => $siswa->nis,
                    'kelas_id' => request('kelasId'),
                    'tahun' => request('tahun'),
                    'kategori_alquran_id' => EnumKategoriAlquran::BILGHOIB,
                    'jenis_alquran_id' => request('jenisAlquran'),
                    'nilai' => request('nilai'),
                    'user_id' => auth()->user()->id
                ]
            );
        }

        return to_route('input-nilai-bilghoib-per-kelas', ['tahun' => request('tahun'), 'kelasId' => request('kelasId'), 'jenisAlquran' => request('jenisAlquran')]);
    }

    public function hapus()
    {
        PenilaianAlquran::destroy(request('id'));

        return to_route('input-nilai-bilghoib-per-kelas', ['tahun' => request('tahun'), 'kelasId' => request('kelasId'), 'jenisAlquran' => request('jenisAlquran')]);
    }
}
