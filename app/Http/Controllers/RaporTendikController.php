<?php

namespace App\Http\Controllers;

use App\Models\PenilaianGuru;
use App\Models\WaliKelas;
use App\Traits\GuruTrait;
use App\Traits\InitTrait;
use App\Models\PenilaianRaporGuru;
use EnumKategoriGuru;

class RaporTendikController extends Controller
{
    use InitTrait;
    use GuruTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $cekWaliKelas = WaliKelas::whereTahun(request('tahun'))
            ->whereUserId(auth()->user()->id)
            ->count();

        if (auth()->user()->hasRole('Guru')) {
            $penilaian = PenilaianRaporGuru::whereTahun(request('tahun'))
                ->whereKategoriNilaiId(EnumKategoriGuru::Guru)
                ->with([
                    'jenis',
                    'nilai' => fn ($q) => $q->whereTahun(request('tahun'))
                        ->whereKategoriNilaiId(EnumKategoriGuru::Guru)
                        ->whereUserId(auth()->user()->id)
                ])
                ->get();
        } else {
            $penilaian = PenilaianRaporGuru::whereTahun(request('tahun'))
                ->whereKategoriNilaiId(EnumKategoriGuru::Karyawan)
                ->with([
                    'jenis',
                    'nilai' => fn ($q) => $q->whereTahun(request('tahun'))
                        ->whereKategoriNilaiId(EnumKategoriGuru::Karyawan)
                        ->whereUserId(auth()->user()->id)
                ])
                ->get();
        }

        return inertia('Guru/RaporTendik', [
            'initTahun' => $this->data_tahun_lama(),
            'penilaian' => $penilaian,
            'cekWaliKelas' => $cekWaliKelas,
            'penilaianWaliKelas' => PenilaianRaporGuru::whereTahun(request('tahun'))
                ->whereKategoriNilaiId(EnumKategoriGuru::WaliKelas)
                ->with([
                    'jenis',
                    'nilai' => fn ($q) => $q->whereTahun(request('tahun'))
                        ->whereKategoriNilaiId(EnumKategoriGuru::WaliKelas)
                        ->whereUserId(auth()->user()->id)
                ])
                ->get(),
            'avgGuru' => floor(PenilaianGuru::whereTahun(request('tahun'))
                ->whereUserId(auth()->user()->id)
                ->whereKategoriNilaiId(EnumKategoriGuru::Guru)
                ->avg('nilai')),
            'avgWali' => floor(PenilaianGuru::whereTahun(request('tahun'))
                ->whereUserId(auth()->user()->id)
                ->whereKategoriNilaiId(EnumKategoriGuru::WaliKelas)
                ->avg('nilai'))
        ]);
    }
}
