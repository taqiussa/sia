<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use EnumKategoriAlquran;
use App\Traits\InitTrait;
use App\Models\JenisAlquran;
use App\Models\PenilaianAlquran;

class InputNilaiBinnadzorPerKelasController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/InputNilaiBinnadzorPerKelas',
            [
                'initTahun' => $this->data_tahun(),
                'listJenisAlquran' => JenisAlquran::whereKategoriAlquranId(EnumKategoriAlquran::BINNADZOR)
                    ->get(),
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
                    'kategori_alquran_id' => EnumKategoriAlquran::BINNADZOR,
                    'jenis_alquran_id' => request('jenisAlquran'),
                    'nilai' => request('nilai'),
                    'user_id' => auth()->user()->id
                ]
            );
        }

        return to_route('input-nilai-binnadzor-per-kelas');
    }

    public function hapus()
    {
        PenilaianAlquran::destroy(request('id'));

        return to_route('input-nilai-binnadzor-per-kelas');
    }
}
