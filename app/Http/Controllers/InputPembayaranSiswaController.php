<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Transaksi;
use App\Traits\InitTrait;

class InputPembayaranSiswaController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Bendahara/InputPembayaranSiswa',
            [
                'initTahun' => $this->data_tahun()
            ]
        );
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'tanggal' => 'required',
            'nis' => 'required',
        ]);


        $siswa = Siswa::whereTahun(request('tahun'))
            ->whereNis(request('nis'))
            ->first();

        $transaksi = Transaksi::create([
            'tanggal' => request('tanggal'),
            'tahun' => request('tahun'),
            'tingkat' => $siswa->tingkat,
            'nis' => request('nis'),
            'kelas_id' => $siswa->kelas_id,
            'jumlah' => $this->ambilAngka(request('total')),
            'user_id' => auth()->user()->id
        ]);

        foreach (request('arrayInput') as $input) {

            $transaksi->pembayarans()->create([
                'tanggal' => request('tanggal'),
                'tahun' => request('tahun'),
                'tingkat' => $siswa->tingkat,
                'nis' => request('nis'),
                'kelas_id' => $siswa->kelas_id,
                'kategori_pemasukan_id' => 1,
                'gunabayar_id' => $input,
                'jumlah' => $this->ambilAngka(request('jumlah')),
                'user_id' => auth()->user()->id
            ]);
        }

        return to_route('input-pembayaran-siswa');
    }

    public function hapus()
    {
        Transaksi::destroy(request('id'));

        Pembayaran::whereTransaksiId(request('id'))
            ->delete();

        return to_route(request('route'));
    }
}
