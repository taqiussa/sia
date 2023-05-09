<?php

namespace App\Http\Controllers;

use App\Models\Gunabayar;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use App\Models\WajibBayar;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class RekapPembayaranSiswaController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/RekapPembayaranSiswa',
            [
                'initTahun' => $this->data_tahun(),
                'listKelas' => Kelas::orderBy('nama')->get(),
                'listSiswa' => $this->data_siswa_per_kelas()
            ]
        );
    }

    public function print()
    {
        $kelas = Kelas::find(request('kelasId'));

        $siswa = Siswa::whereNis(request('nis'))
            ->whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'kelas',
                'pembayarans' => fn ($q) => $q->whereTahun(request('tahun')),
                'user',
            ])
            ->first();

        $wajibBayar = WajibBayar::whereTahun(request('tahun'))
            ->whereTingkat($kelas->tingkat)
            ->value('jumlah');

        $data = [
            'tahun' => request('tahun'),
            'siswa' => $siswa,
            'listGunabayar' => Gunabayar::get(),
            'namaBendahara' => User::role('Bendahara')->get(),
            'wajibBayar' => $wajibBayar
        ];

        return view('print.guru.print-rekap-pembayaran-siswa', $data);
    }
}
