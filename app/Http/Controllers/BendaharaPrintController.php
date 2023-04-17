<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Siswa;
use App\Models\Pemasukan;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use App\Models\WajibBayar;
use App\Models\KategoriPemasukan;
use App\Http\Controllers\Controller;

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

    // Rekap Pemasukan

    public function rekap_harian_pemasukan_detail()
    {
        $subtotalPemasukan = Pemasukan::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])->sum('jumlah');
        $subtotalPembayaran = Pembayaran::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])->sum('jumlah');
        $total = $subtotalPembayaran + $subtotalPemasukan;
        $data = [
            'kepalaSekolah' => User::role('Kepala Sekolah')->first()->name,
            'tanggalAwal' => request('tanggalAwal'),
            'tanggalAkhir' => request('tanggalAkhir'),
            'listPembayaran' => Pembayaran::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])
                ->with([
                    'gunabayar',
                    'kelas',
                    'siswa',
                    'user'
                ])
                ->get(),
            'subtotalPembayaran' => $subtotalPembayaran,
            'listPemasukan' => Pemasukan::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])
                ->with([
                    'kategori',
                    'user'
                ])
                ->get(),
            'subtotalPemasukan' => $subtotalPemasukan,
            'total' => $total,
        ];
        return view('print.bendahara.rekap-harian-pemasukan-detail', $data);
    }

    public function rekap_harian_pemasukan_simple()
    {
        $subtotalPemasukan = Pemasukan::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])->sum('jumlah');
        $subtotalPembayaran = Pembayaran::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])->sum('jumlah');
        $total = $subtotalPembayaran + $subtotalPemasukan;
        $data = [
            'kepalaSekolah' => User::role('Kepala Sekolah')->first()->name,
            'tanggalAwal' => request('tanggalAwal'),
            'tanggalAkhir' => request('tanggalAkhir'),
            'subtotalPembayaran' => $subtotalPembayaran,
            'listKategori' => KategoriPemasukan::where('nama', '!=', 'SPP')
                ->with(['pemasukan' => fn ($q) => $q->whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])])
                ->orderBy('nama')->get(),
            'total' => $total,
        ];
        return view('print.bendahara.rekap-harian-pemasukan-simple', $data);
    }

    public function rekap_tahunan_pemasukan_detail()
    {
        $subtotalPemasukan = Pemasukan::whereTahun(request('tahun'))->sum('jumlah');
        $subtotalPembayaran = Pembayaran::whereTahun(request('tahun'))->sum('jumlah');
        $total = $subtotalPembayaran + $subtotalPemasukan;
        $data = [
            'kepalaSekolah' => User::role('Kepala Sekolah')->first()->name,
            'tahun' => request('tahun'),
            'listPembayaran' => Pembayaran::whereTahun(request('tahun'))
                ->with([
                    'gunabayar',
                    'kelas',
                    'siswa',
                    'user'
                ])
                ->get(),
            'subtotalPembayaran' => $subtotalPembayaran,
            'listPemasukan' => Pemasukan::whereTahun(request('tahun'))
                ->with([
                    'kategori',
                    'user'
                ])
                ->get(),
            'subtotalPemasukan' => $subtotalPemasukan,
            'total' => $total,
        ];
        return view('print.bendahara.rekap-tahunan-pemasukan-detail', $data);
    }

    public function rekap_tahunan_pemasukan_simple()
    {
        $subtotalPemasukan = Pemasukan::whereTahun(request('tahun'))->sum('jumlah');
        $subtotalPembayaran = Pembayaran::whereTahun(request('tahun'))->sum('jumlah');
        $total = $subtotalPembayaran + $subtotalPemasukan;
        $data = [
            'kepalaSekolah' => User::role('Kepala Sekolah')->first()->name,
            'tahun' => request('tahun'),
            'subtotalPembayaran' => $subtotalPembayaran,
            'listKategori' => KategoriPemasukan::where('nama', '!=', 'SPP')
                ->with(['pemasukan' => fn ($q) => $q->whereTahun(request('tahun'))])
                ->orderBy('nama')->get(),
            'total' => $total,
        ];
        return view('print.bendahara.rekap-tahunan-pemasukan-simple', $data);
    }
}
