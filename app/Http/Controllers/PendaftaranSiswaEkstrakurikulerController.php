<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\Siswa;
use App\Models\SiswaEkstra;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class PendaftaranSiswaEkstrakurikulerController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/PendaftaranSiswaEkstrakurikuler',
            [
                'initTahun' => $this->data_tahun(),
                'listEkstrakurikuler' => Ekstrakurikuler::orderBy('nama')->get(),
            ]
        );
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'ekstrakurikulerId' => 'required',
            'nis' => 'required'
        ]);

        $siswa = Siswa::whereTahun(request('tahun'))
            ->whereNis(request('nis'))
            ->first();

        SiswaEkstra::create([
            'tahun' => request('tahun'),
            'ekstrakurikuler_id' => request('ekstrakurikulerId'),
            'kelas_id' => $siswa->kelas_id,
            'tingkat' => $siswa->tingkat,
            'nis' => request('nis')
        ]);

        return to_route('pendaftaran-siswa-ekstrakurikuler');
    }

    public function hapus()
    {
        SiswaEkstra::destroy(request('id'));

        return to_route('pendaftaran-siswa-ekstrakurikuler');
    }
}
