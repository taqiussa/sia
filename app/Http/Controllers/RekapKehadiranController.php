<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kehadiran;
use App\Models\Kelas;
use App\Models\PenilaianSkor;
use App\Models\Siswa;
use App\Models\Skor;
use App\Traits\InitTrait;

class RekapKehadiranController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia('Guru/RekapKehadiran', [
            'totalSiswa' => Siswa::whereTahun($this->data_tahun())
                ->count()
        ]);
    }

    public function detail()
    {
        return inertia(
            'Guru/RekapKehadiranDetail',
            [
                'initTanggal' => request('tanggal'),
                'initJam' => request('jam'),
                'initKehadiranId' => request('kehadiranId'),
                'listKehadiran' => Kehadiran::get(),
                'listAbsensi' => Absensi::whereTanggal(request('tanggal'))
                    ->whereJam(request('jam'))
                    ->whereKehadiranId(request('kehadiranId'))
                    ->with([
                        'kehadiran' => fn ($q) => $q->select('id', 'nama'),
                        'siswa' => fn ($q) => $q->select('nis', 'name'),
                    ])
                    ->get(),
                'sudahSkorAlpha' => PenilaianSkor::whereTanggal(request('tanggal'))
                    ->whereSkorId(58)
                    ->get(),
                'sudahSkorBolos' => PenilaianSkor::whereTanggal(request('tanggal'))
                    ->whereSkorId(47)
                    ->get(),
            ]
        );
    }

    public function simpan()
    {
        $siswa = Siswa::whereTahun($this->data_tahun())
            ->whereNis(request('nis'))
            ->first();

        $skor = Skor::find(request('skorId'));

        PenilaianSkor::create([
            'tanggal' => request('tanggal'),
            'tahun' => $this->data_tahun(),
            'semester' => $this->data_semester(),
            'kelas_id' => $siswa->kelas_id,
            'user_id' => auth()->user()->id,
            'skor_id' => request('skorId'),
            'skor' => $skor->skor,
            'nis' => request('nis')
        ]);

        return to_route('rekap-kehadiran.detail', [
            'tanggal' => request('tanggal'),
            'jam' => request('jam'),
            'kehadiranId' => request('kehadiranId')
        ]);
    }
}
