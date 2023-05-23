<?php

namespace App\Http\Controllers;

use App\Models\AturanKurikulum;
use App\Models\Siswa;
use App\Models\BkDetail;
use App\Models\JenisPenilaian;
use App\Models\KurikulumMapel;
use App\Traits\InitTrait;
use App\Models\Pembayaran;
use App\Models\PenilaianRapor;
use App\Models\PenilaianSkor;
use App\Models\WajibBayar;

class GetDataSiswaController extends Controller
{
    use InitTrait;

    public function get_administrasi()
    {
        $tingkat = Siswa::whereTahun(request('tahun'))
            ->whereNis(auth()->user()->nis)
            ->value('tingkat');

        return response()->json(
            [
                'listData' => Pembayaran::whereTahun(request('tahun'))
                    ->whereNis(auth()->user()->nis)
                    ->with([
                        'gunabayar' => fn ($q) => $q->select('id', 'nama'),
                    ])
                    ->get(),
                'wajibBayar' => WajibBayar::whereTahun(request('tahun'))
                    ->whereTingkat($tingkat)
                    ->value('jumlah')
            ]
        );
    }

    public function get_data_bimbingan()
    {
        return response()->json([
            'listBimbingan' => BkDetail::whereTahun(request('tahun'))
                ->whereNis(auth()->user()->nis)
                ->with(['user' => fn ($q) => $q->select('id', 'name')])
                ->get()
        ]);
    }

    public function get_data_nilai()
    {
        $siswa = Siswa::whereTahun(request('tahun'))
            ->whereNis(auth()->user()->nis)
            ->with([
                'penilaians' => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereSemester(request('semester'))
            ])
            ->first();

        $aturanKurikulum = AturanKurikulum::whereTahun(request('tahun'))
            ->whereTingkat($siswa->tingkat)
            ->first();

        $kurikulumMapel = KurikulumMapel::whereTahun(request('tahun'))
            ->whereTingkat($siswa->tingkat)
            ->whereKurikulumId($aturanKurikulum->kurikulum_id)
            ->with(['mapel'])
            ->get();

        $penilaianRapor = PenilaianRapor::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->whereTingkat($siswa->tingkat)
            ->pluck('jenis_penilaian_id');

        return response()->json([
            'listMapel' => $kurikulumMapel,
            'listJenis' => JenisPenilaian::whereIn('id', $penilaianRapor)->get(),
            'listPenilaian' => $siswa->penilaians
        ]);
    }

    public function get_data_skor()
    {
        return response()->json([
            'listSkor' => PenilaianSkor::whereTahun(request('tahun'))
                ->whereNis(auth()->user()->nis)
                ->with([
                    'user' => fn ($q) => $q->select('id', 'name'),
                    'skors'
                ])
                ->orderByDesc('tanggal')
                ->get()
        ]);
    }
}
