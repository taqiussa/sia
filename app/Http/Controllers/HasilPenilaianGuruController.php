<?php

namespace App\Http\Controllers;

use App\Models\KategoriPenilaianGuru;
use App\Models\PenilaianRaporGuru;
use App\Models\User;
use App\Models\WaliKelas;
use App\Traits\InitTrait;

class HasilPenilaianGuruController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        switch (request('kategoriNilaiId')) {
            case '1':
                $user = User::role('Guru')
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
                $user = User::role('Karyawan')
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
                $user = WaliKelas::whereTahun(request('tahun'))
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
                $user =[];
                break;
        }

        return inertia(
            'Guru/HasilPenilaianGuru',
            [
                'initTahun' => $this->data_tahun(),
                'listKategori' =>  KategoriPenilaianGuru::orderBy('nama')->get(),
                'listJenis' => PenilaianRaporGuru::whereTahun(request('tahun'))
                    ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->with('jenis')
                    ->get(),
                'listUser' => $user
            ]
        );
    }
}
