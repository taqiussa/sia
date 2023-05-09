<?php

namespace App\Http\Controllers;

use App\Models\JamKosong;
use App\Models\User;
use App\Traits\InitTrait;

class JadwalJamKosongController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/JadwalJamKosong',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listUser' => User::where('username', '!=', null)
                    ->where('username', '!=', 'administrator')
                    ->orderBy('name')
                    ->get(),
                'listJadwal' => JamKosong::whereUserId(request('userId'))
                    ->orderBy('semester')
                    ->orderBy('hari')
                    ->orderBy('jam')
                    ->get()
            ]
        );
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'userId' => 'required',
            'hari' => 'required',
            'jam' => 'required',
        ]);

        JamKosong::create([
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'hari' => request('hari'),
            'jam' => request('jam'),
            'user_id' => request('userId'),
        ]);

        return to_route(
            'jadwal-jam-kosong',
            [
                'userId' => request('userId')
            ]
        );
    }

    public function hapus()
    {
        JamKosong::destroy(request('id'));

        return to_route(
            'jadwal-jam-kosong',
            [
                'userId' => request('userId')
            ]
        );
    }
}
