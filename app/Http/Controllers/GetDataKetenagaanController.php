<?php

namespace App\Http\Controllers;

use App\Models\Badalan;
use App\Models\User;
use App\Traits\InitTrait;
use Carbon\Carbon;

class GetDataKetenagaanController extends Controller
{
    use InitTrait;

    public function get_permintaan_badal()
    {
        return response()->json([
            'listPermintaan' => Badalan::whereTanggal(request('tanggal'))
                ->whereNull('badal_id')
                ->with([
                    'badal' => fn ($q) => $q->select('id', 'name'),
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'mapel' => fn ($q) => $q->select('id', 'nama'),
                    'user' => fn ($q) => $q->select('id', 'name'),
                ])
                ->orderBy('jam')
                ->get()
        ]);
    }

    public function get_guru_izin()
    {
        return response()->json([
            'listGuruIzin' => Badalan::whereTanggal(request('tanggal'))
                ->pluck('user_id')
        ]);
    }

    public function get_guru_kosong()
    {
        $hari = Carbon::parse(request('tanggal'))
            ->dayOfWeek;

        return response()->json([
            'listGuruKosong' => User::withCount([
                'jamKosong' => fn ($q) => $q->whereHari($hari)
                    ->whereTahun($this->data_tahun())
                    ->whereSemester($this->data_semester())
            ])
                ->withWhereHas('jamKosong', fn ($q) => $q->whereHari($hari)
                    ->whereTahun($this->data_tahun())
                    ->whereSemester($this->data_semester()))
                ->orderBy('name')
                ->get()
        ]);
    }

    public function get_guru_sudah_badal()
    {
        return response()->json([
            'listGuruSudahBadal' => Badalan::whereTanggal(request('tanggal'))
                ->where('badal_id', '!=', null)
                ->get()
        ]);
    }
}
