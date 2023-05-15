<?php

namespace App\Http\Controllers;

use App\Models\DeskripsiEkstra;
use App\Models\Ekstrakurikuler;
use App\Traits\InitTrait;

class InputDeskripsiEkstrakurikulerController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia('Guru/InputDeskripsiEkstrakurikuler', [
            'initTahun' => $this->data_tahun(),
            'initSemester' => $this->data_semester(),
        ]);
    }

    public function hapus()
    {
        DeskripsiEkstra::destroy(request('id'));

        return to_route('input-deskripsi-ekstrakurikuler');
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'ekstrakurikulerId' => 'required',
            'deskripsi' => 'required'
        ]);

        DeskripsiEkstra::updateOrCreate(
            [
                'tahun' => request('tahun'),
                'semester' => request('semester'),
                'ekstra_id' => request('ekstrakurikulerId'),
            ],
            [
                'deskripsi' => request('deskripsi')
            ]
        );

        return to_route('input-deskripsi-ekstrakurikuler');
    }
}
