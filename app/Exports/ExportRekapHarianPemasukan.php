<?php

namespace App\Exports;

use App\Models\Pemasukan;
use App\Models\Pembayaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportRekapHarianPemasukan implements FromView
{
    public function view(): View
    {
        $subtotalPemasukan = Pemasukan::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])->sum('jumlah');
        $subtotalPembayaran = Pembayaran::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])->sum('jumlah');
        $total = $subtotalPembayaran + $subtotalPemasukan;
        $data = [
            // 'kepala_sekolah' => User::role('Kepala Sekolah')->get(),
            'tanggalAwal' => request('tanggalAwal'),
            'tanggalAkhir' => request('tanggalAkhir'),
            'listPembayaran' => Pembayaran::with([
                'kelas',
                'siswa',
                'gunabayar'
            ])
                ->whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])
                ->get()
                ->sortBy('kelas.nama'),
            'subtotalPembayaran' => $subtotalPembayaran,
            'listPemasukan' => Pemasukan::with(['kategori'])->whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])->get(),
            'subtotalPemasukan' => $subtotalPemasukan,
            'total' => $total,
        ];
        return view('export.bendahara.rekap-harian-pemasukan', $data);
    }
}
