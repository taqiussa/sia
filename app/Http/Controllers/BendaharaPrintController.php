<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\WajibBayar;

class BendaharaPrintController extends Controller
{
    public function kwitansi()
    {
        $id = request('id');
        $nis = request('nis');
        $tahun = request('tahun');

        $siswa = Siswa::whereTahun($tahun)
            ->whereNis($nis)
            ->with([
                'kelas' => fn ($q) => $q->select('id', 'nama'),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
            ->first();

        $pembayaran = Pembayaran::with('gunabayar')->where('transaksi_id', $id)->get();
        $wajibbayar = WajibBayar::where('tingkat', $siswa->tingkat)->where('tahun', $tahun)->first()->jumlah;
        $totalbayar = Pembayaran::where('nis', $nis)->where('tahun', $tahun)->sum('jumlah');
        $kurangbayar = $wajibbayar - $totalbayar;
        $transaksi = Transaksi::with(['user' => fn ($q) => $q->select('id', 'name')])->find($id);
        $data = [
            'list_pembayaran' => $pembayaran,
            'kelas' => $siswa->kelas->nama,
            'siswa' => $siswa->user->name,
            'tahun' => $tahun,
            'transaksi' => $transaksi,
            'wajibbayar' => $wajibbayar,
            'totalbayar' => $totalbayar,
            'kurangbayar' => $kurangbayar
        ];
        return view('print.bendahara.kwitansi', $data);
    }
}
