<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kehadiran;
use App\Models\RuangUjian;
use App\Models\Siswa;
use App\Traits\InitTrait;
use EnumKehadiran;

class AbsensiUjianController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/AbsensiUjian',
            [
                'initTahun' => $this->data_tahun(),
                'listKehadiran' => Kehadiran::get()
            ]
        );
    }

    public function nihil()
    {
        $siswaRuang = RuangUjian::whereTahun(request('tahun'))
            ->whereSemester($this->data_semester())
            ->whereNamaRuang(request('namaRuang'))
            ->whereNamaUjian(request('namaUjian'))
            ->whereJenisKelamin(request('jenisKelamin'))
            ->pluck('nis');

        $siswaTidakHadir = Absensi::whereTanggal(request('tanggal'))
            ->whereJam(request('jam'))
            ->whereIn('nis', $siswaRuang)
            ->where('kehadiran_id', '!=', EnumKehadiran::HADIR)
            ->pluck('nis');

        $siswaHadir = RuangUjian::whereTahun(request('tahun'))
            ->whereSemester($this->data_semester())
            ->whereNamaRuang(request('namaRuang'))
            ->whereNamaUjian(request('namaUjian'))
            ->whereJenisKelamin(request('jenisKelamin'))
            ->whereNotIn('nis', $siswaTidakHadir)
            ->get();

        foreach ($siswaHadir as $siswa) {
            Absensi::insert([
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
            'listSiswa' => RuangUjian::whereTahun(request('tahun'))
                ->whereSemester($this->data_semester())
                ->whereNamaRuang(request('namaRuang'))
                ->whereNamaUjian(request('namaUjian'))
                ->whereJenisKelamin(request('jenisKelamin'))
                ->with([
                    'absensi' => fn ($q) => $q->whereTanggal(request('tanggal'))
                        ->whereJam(request('jam')),
                    'absensi.guru' => fn ($q) => $q->select('id', 'name'),
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'user' => fn ($q) => $q->select('nis', 'name'),
                ])
                ->get()
                ->sortBy(['kelas.nama', 'user.name'])
                ->values()
        ]);
    }

    public function simpan()
    {
        request()->validate([
            'tanggal' => 'required',
            'tahun' => 'required',
            'namaRuang' => 'required',
            'namaUjian' => 'required',
            'jam' => 'required',
            'kehadiranId' => 'required',
            'nis' => 'required',
            'kelasId' => 'required'
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
