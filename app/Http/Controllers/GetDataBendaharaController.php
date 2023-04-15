<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Transaksi;
use App\Models\WajibBayar;

class GetDataBendaharaController extends Controller
{

    public function get_pembayaran_siswa()
    {
        $siswa =  Siswa::whereTahun(request('tahun'))
            ->whereNis(request('nis'))
            ->with([
                'alamat',
                'alamat.provinsi',
                'kelas' => fn ($q) => $q->select('id', 'nama'),
                'pembayarans' => fn ($q) => $q->whereTahun(request('tahun')),
                'pembayarans.user' => fn ($q) => $q->select('id', 'name'),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
            ->withSum([
                'transaksis as totalBayar' => fn ($q) => $q->whereTahun(request('tahun'))
            ], 'jumlah')
            ->first();

        $wajibBayar = WajibBayar::whereTahun(request('tahun'))
            ->whereTingkat($siswa->tingkat)
            ->value('jumlah');

        return response()->json([
            'dataSiswa' => $siswa,
            'listPembayaran' => Transaksi::whereTahun(request('tahun'))
                ->whereNis(request('nis'))
                ->with([
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'user' => fn ($q) => $q->select('id', 'name')
                ])
                ->orderByDesc('created_at')
                ->get(),
            'wajibBayar' => $wajibBayar
        ]);
    }

    public function get_wajib_bayar()
    {
        return response()->json([
            'listWajibBayar' => WajibBayar::whereTahun(request('tahun'))
                ->get()
        ]);
    }
}