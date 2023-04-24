<?php

namespace App\Http\Controllers;

use App\Models\AbsensiEkstra;
use App\Models\Ekstrakurikuler;
use App\Models\Kehadiran;
use App\Models\SiswaEkstra;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;
use EnumKehadiran;

class AbsensiEkstrakurikulerController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/AbsensiEkstrakurikuler',
            [
                'initTahun' => $this->data_tahun(),
                'listEkstrakurikuler' => Ekstrakurikuler::orderBy('nama')->get(),
                'listKehadiran' => Kehadiran::get()
            ]
        );
    }

    public function nihil()
    {
        request()->validate([
            'tanggal' => 'required',
            'tahun' => 'required',
            'ekstrakurikulerId' => 'required',
            'jenisKelamin' => 'required'
        ]);

        $siswaBelumTerabsen = SiswaEkstra::whereTahun(request('tahun'))
            ->whereEkstrakurikulerId(request('ekstrakurikulerId'))
            ->withWhereHas('biodata', fn ($q) => $q->whereJenisKelamin(request('jenisKelamin')))
            ->whereDoesntHave('absensi', fn ($q) => $q->whereTanggal(request('tanggal')))
            ->get();


        foreach ($siswaBelumTerabsen as $siswa) {
            AbsensiEkstra::create([
                'tanggal' => request('tanggal'),
                'tahun' => request('tahun'),
                'semester' => $this->data_semester(),
                'ekstrakurikuler_id' => request('ekstrakurikulerId'),
                'kelas_id' => $siswa->kelas_id,
                'nis' => $siswa->nis,
                'kehadiran_id' => EnumKehadiran::HADIR,
                'user_id' => auth()->user()->id
            ]);
        }

        return response()->json(['listSiswa' => $this->data_siswa_ekstra_with_absensi()]);
    }

    public function simpan()
    {
        request()->validate([
            'tanggal' => 'required',
            'tahun' => 'required',
            'ekstrakurikulerId' => 'required',
            'nis' => 'required',
            'kehadiranId' => 'required'
        ]);

        AbsensiEkstra::updateOrCreate(
            ['id' => request('id')],
            [
                'tanggal' => request('tanggal'),
                'tahun' => request('tahun'),
                'semester' => $this->data_semester(),
                'ekstrakurikuler_id' => request('ekstrakurikulerId'),
                'kelas_id' => request('kelasId'),
                'nis' => request('nis'),
                'kehadiran_id' => request('kehadiranId'),
                'user_id' => auth()->user()->id
            ]
        );

        return response()->json([
            'message' => 'Tersimpan',
            'nis' => request('nis')
        ]);
    }
}
