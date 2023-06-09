<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\BkDetail;
use App\Models\PenilaianSkor;

class GetDataBkController extends Controller
{
    public function get_rekap_bimbingan()
    {
        return response()->json([
            'listBimbingan' => BkDetail::with(
                [
                    'bk',
                    'bk.user' => fn ($q) => $q->select('id', 'name'),
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'user' => fn ($q) => $q->select('nis', 'name')
                ]
            )
                ->whereHas('bk', fn ($q) => $q->whereBentukBimbingan(request('bentukBimbingan'))
                    ->whereTahun(request('tahun')))
                ->latest()
                ->get()
                ->values()
        ]);
    }

    public function get_rekap_kehadiran()
    {
        return response()->json(
            [
                'listAbsensi' => Absensi::whereTanggal(request('tanggal'))
                    ->whereJam(request('jam'))
                    ->get(),
            ]
        );
    }

    public function get_rekap_skor()
    {
        return response()->json([
            'listRekapSkor' => PenilaianSkor::whereTahun(request('tahun'))
                ->with([
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'siswa' => fn ($q) => $q->select('nis', 'name'),
                    'skors' => fn ($q) => $q->select('id', 'keterangan', 'skor'),
                    'user' => fn ($q) => $q->select('id', 'name'),
                ])
                ->latest()
                ->get()
        ]);
    }
}
