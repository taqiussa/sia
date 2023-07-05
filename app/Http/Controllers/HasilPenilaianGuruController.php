<?php

namespace App\Http\Controllers;

use App\Models\KategoriPenilaianGuru;
use App\Models\PenilaianRaporGuru;
use App\Models\User;
use App\Models\WaliKelas;
use App\Traits\GuruTrait;
use App\Traits\InitTrait;

class HasilPenilaianGuruController extends Controller
{
    use InitTrait;
    use GuruTrait;

    public function index()
    {
        return inertia(
            'Guru/HasilPenilaianGuru',
            [
                'initTahun' => $this->data_tahun(),
                'listKategori' =>  KategoriPenilaianGuru::orderBy('nama')->get(),
                'listJenis' => $this->list_jenis_penilaian_guru(),
                'listUser' => $this->kategori_tendik()
            ]
        );
    }

    public function print()
    {
        $data = [
            'tahun' => request('tahun'),
            'listJenis' => $this->list_jenis_penilaian_guru(),
            'listUser' => $this->kategori_tendik(),
        ];

        return view('print.guru.print-hasil-penilaian-guru', $data);
    }

    private function kategori_tendik()
    {
        switch (request('kategoriNilaiId')) {
            case '1':
                return User::role('Guru')
                    ->whereJenisKelamin(request('jenisKelamin'))
                    ->with([
                        'penilaians' => fn ($q) => $q->whereTahun(request('tahun'))
                            ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ])
                    ->withAvg([
                        'penilaians' => fn ($q) => $q->whereTahun(request('tahun'))
                            ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ], 'nilai')
                    ->get()
                    ->sortByDesc('penilaians_avg_nilai')
                    ->values();
                break;
            case '2':
                return User::role('Karyawan')
                    ->with([
                        'penilaians' => fn ($q) => $q->whereTahun(request('tahun'))
                            ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ])
                    ->withAvg([
                        'penilaians' => fn ($q) => $q->whereTahun(request('tahun'))
                            ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ], 'nilai')
                    ->get()
                    ->sortByDesc('penilaians_avg_nilai')
                    ->values();
                break;
            case '3':
                return WaliKelas::whereTahun(request('tahun'))
                    ->whereHas('user', fn ($q) => $q->whereJenisKelamin(request('jenisKelamin')))
                    ->with([
                        'penilaians' => fn ($q) => $q->whereTahun(request('tahun'))
                            ->whereKategoriNilaiId(request('kategoriNilaiId')),
                        'user'
                    ])
                    ->withAvg([
                        'penilaians' => fn ($q) => $q->whereTahun(request('tahun'))
                            ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ], 'nilai')
                    ->get()
                    ->sortByDesc('penilaians_avg_nilai')
                    ->values();
                break;

            default:
                return [];
                break;
        }
    }
}
