<?php

namespace App\Http\Controllers;

use App\Models\Sosial;
use App\Models\SosialDetail;
use App\Models\User;
use App\Traits\GuruTrait;
use App\Traits\InitTrait;
use EnumKehadiranIbadah;

class InputSosialController extends Controller
{
    use InitTrait;
    use GuruTrait;

    public function index()
    {
        return inertia('Guru/InputSosial', [
            'initTahun' => $this->data_tahun(),
            'initSemester' => $this->data_semester(),
        ]);
    }

    public function nihil()
    {
        request()->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'tanggal' => 'required',
            'keterangan' => 'required'
        ]);

        try {

            $sosial = Sosial::updateOrCreate(
                [],
                [
                    'tahun' => request('tahun'),
                    'semester' => request('semester'),
                    'tanggal' => request('tanggal'),
                    'keterangan' => request('keterangan'),
                ]
            );

            $userBelumAbseni = User::role(request('role'))
                ->whereDoesntHave('sosialDetail', fn ($q) => $q->whereTanggal(request('tanggal')))
                ->get();

            foreach ($userBelumAbseni as $user)
                $sosial->detail()->updateOrCreate(
                    [
                        'tahun' => request('tahun'),
                        'semester' => request('semester'),
                        'tanggal' => request('tanggal'),
                        'user_id' => $user->id
                    ],
                    [
                        'kehadiran_id' => EnumKehadiranIbadah::Hadir
                    ]
                );

            return to_route('input-sosial');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function simpan()
    {

        request()->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'tanggal' => 'required',
            'keterangan' => 'required'
        ]);

        SosialDetail::updateOrCreate(
            ['id' => request('id')],
            [
                'sosial_id' => request('sosialId'),
                'tahun' => request('tahun'),
                'semester' => request('semester'),
                'tanggal' => request('tanggal'),
                'user_id' => request('userId'),
                'kehadiran_id' => request('kehadiranId')
            ]
        );

        return response()->json([
            'listUser' => $this->data_absensi_sosial(),
            'message' => 'Tersimpan',
            'id' => request('userId')
        ]);
    }
}
