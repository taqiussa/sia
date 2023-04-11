<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Transaksi;
use App\Traits\InitTrait;

use function App\Helpers\ambilAngka;

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
            'jumlah' => ambilAngka(request('jumlah')),
            'user_id' => auth()->user()->id
        ]);

        
    }
}
