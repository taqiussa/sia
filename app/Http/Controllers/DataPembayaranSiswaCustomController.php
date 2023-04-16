<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Traits\InitTrait;
use Illuminate\Http\Request;

class DataPembayaranSiswaCustomController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (request('tahun')) {
            $pembayaran = Transaksi::when(request('search'), fn ($q)
                =>
                $q->whereHas(
                    'siswa',
                    fn ($q) =>
                    $q->where('name', 'like', '%' . request('search') . '%')
                ))
                ->whereTahun(request('tahun'))
                ->with([
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'siswa' => fn ($q) => $q->select('nis', 'name'),
                    'user' => fn ($q) => $q->select('id', 'name'),
                ])
                ->latest()
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($q) => [
                    'id' => $q->id,
                    'jumlah' => $q->jumlah,
                    'tanggal' => $q->tanggal,
                    'siswa' => $q->siswa,
                    'kelas' => $q->kelas,
                    'user' => $q->user
                ]);
        } else {
            $pembayaran = Transaksi::when(request('search'), fn ($q)
                =>
                $q->whereHas(
                    'siswa',
                    fn ($q) =>
                    $q->where('name', 'like', '%' . request('search') . '%')
                ))
                ->whereTahun($this->data_tahun())
                ->with([
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'siswa' => fn ($q) => $q->select('nis', 'name'),
                    'user' => fn ($q) => $q->select('id', 'name'),
                ])
                ->latest()
                ->paginate(10)
                ->withQueryString()
                ->through(fn ($q) => [
                    'id' => $q->id,
                    'jumlah' => $q->jumlah,
                    'tanggal' => $q->tanggal,
                    'siswa' => $q->siswa,
                    'kelas' => $q->kelas,
                    'user' => $q->user
                ]);
        }

        return inertia(
            'Bendahara/DataPembayaranSiswaCustom',
            [
                'initTahun' => $this->data_tahun(),
                'listPembayaran' => $pembayaran,
                'filters' => request()->only('search')
            ]
        );
    }
}
