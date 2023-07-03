<?php

namespace App\Http\Controllers;

use App\Models\Ibadah;
use App\Models\User;
use App\Traits\InitTrait;

class InputIbadahController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/InputIbadah',
            [
                'initTahun' => $this->data_tahun(),
            ]
        );
    }

    public function nihil()
    {
        request()->validate([
            'tahun' => 'required',
            'semester' => 'required',
            'tanggal' => 'required',
            'keterangan' => 'required',
            'jenisKelamin' => 'required'
        ]);

        try {
            
            $sosial = Ibadah::updateOrCreate(
                [
                  'tahun' => request('tahun'),
                  'bulan' => request('bulan'),
                  'minggu' => request('minggu'),
                  'jenis_ibadah' => request('jenis_ibadah'),
                  'tahun' => request('tahun'),
                  'tahun' => request('tahun'),
                ]
            );

            $userBelumAbseni = User::role(request('role'))
                ->whereJenisKelamin(request('jenisKelamin'))
                ->whereDoesntHave('sosial_detail', fn ($q) => $q->whereTanggal(request('tanggal')))
                ->get();

            foreach ($userBelumAbseni as $user) {
                $sosial->detail()->updateOrCreate(
                    [
                        'tanggal' => request('tanggal'),
                        'user_id' => $user->id
                    ],
                    [
                        'tahun' => request('tahun'),
                        'semester' => request('semester'),
                        'kehadiran_id' => EnumKehadiranIbadah::Hadir
                    ]
                );
            }

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
            'keterangan' => 'required',
            'jenisKelamin' => 'required'
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
