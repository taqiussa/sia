<?php

namespace App\Http\Controllers;

use EnumKehadiran;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\Kehadiran;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class AbsensiController extends Controller
{
    use InitTrait;
    use SiswaTrait;

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
                'listSiswa' => $this->data_siswa_with_absensi()
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

        $siswaBelumTerabsen = Siswa::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->whereDoesntHave('absensi', fn ($q) => $q->whereTanggal(request('tanggal'))
                ->whereJam(request('jam')))
            ->get();

        foreach ($siswaBelumTerabsen as $siswa) {
            Absensi::create([
                'nis' => $siswa->nis,
                'kelas_id' => $siswa->kelas_id,
                'kehadiran_id' => EnumKehadiran::HADIR,
                'tahun' => request('tahun'),
                'semester' => $this->data_semester(),
                'tanggal' => request('tanggal'),
                'jam' => request('jam'),
                'user_id' => auth()->user()->id
            ]);
        }

        return response()->json([
            'listSiswa' => $this->data_siswa_with_absensi()
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
