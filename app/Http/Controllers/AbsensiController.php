<?php

namespace App\Http\Controllers;

use EnumKehadiran;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\Kehadiran;
use App\Traits\InitTrait;

class AbsensiController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/Absensi',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listInfo' => Absensi::whereTanggal(request('tanggal'))
                    ->whereKelasId(request('kelasId'))
                    ->where('kehadiran_id', '!=', EnumKehadiran::HADIR)
                    ->with([
                        'siswa' => fn ($q) => $q->select('nis', 'name'),
                        'kehadiran' => fn ($q) => $q->select('id', 'nama')
                    ])
                    ->get()
                    ->sortBy(['user.name', 'jam'])
                    ->values(),
                'listKelas' => Kelas::orderBy('nama')->get(),
                'listKehadiran' => Kehadiran::get(),
                'listSiswa' => Siswa::whereTahun(request('tahun'))
                    ->whereKelasId(request('kelasId'))
                    ->with([
                        'user' => fn ($q) => $q->select('nis', 'name'),
                        'absensi' => fn ($q) => $q
                            ->whereTanggal(request('tanggal'))
                            ->whereJam(request('jam')),
                        'absensi.guru' => fn ($q) => $q->select('id', 'name'),
                    ])
                    ->get()
                    ->sortBy('user.name')
                    ->values()
            ]
        );
    }

    public function nihil()
    {
        request()->validate([
            'tanggal' => 'required',
            'tahun' => 'required',
            'jam' => 'required',
            'kelasId' => 'required'
        ]);

        $siswaTidakHadir = Absensi::whereTanggal(request('tanggal'))
            ->whereKelasId(request('kelasId'))
            ->whereJam(request('jam'))
            ->where('kehadiran_id', '!=', EnumKehadiran::HADIR)
            ->pluck('nis');

        $siswa = Siswa::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->whereNotIn('nis', $siswaTidakHadir)
            ->get();

        foreach ($siswa as $absensi) {
            Absensi::insert([
                'nis' => $absensi->nis,
                'kelas_id' => $absensi->kelas_id,
                'kehadiran_id' => EnumKehadiran::HADIR,
                'tahun' => request('tahun'),
                'semester' => $this->data_semester(),
                'tanggal' => request('tanggal'),
                'jam' => request('jam'),
                'user_id' => auth()->user()->id
            ]);
        }

        return response()->json([
            'listSiswa' => Siswa::whereTahun(request('tahun'))
                ->whereKelasId(request('kelasId'))
                ->with(
                    [
                        'user' => fn ($q) => $q->select('nis', 'name'),
                        'absensi' => fn ($q) => $q
                            ->whereTanggal(request('tanggal'))
                            ->whereJam(request('jam')),
                        'absensi.guru' => fn ($q) => $q->select('id', 'name'),
                    ]
                )
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }

    public function simpan()
    {
        request()->validate([
            'tanggal' => 'required',
            'tahun' => 'required',
            'jam' => 'required',
            'kelasId' => 'required',
        ]);

        Absensi::updateOrCreate(
            ['id' => request('id')],
            [
                'nis' => request('nis'),
                'kelas_id' => request('kelasId'),
                'kehadiran_id' => request('kehadiranId'),
                'tahun' => request('tahun'),
                'semester' => $this->data_semester(),
                'tanggal' => request('tanggal'),
                'jam' => request('jam'),
                'user_id' => auth()->user()->id
            ]
        );

        return response()->json([
            'message' => 'Tersimpan',
            'nis' => request('nis')
        ]);
    }
}
