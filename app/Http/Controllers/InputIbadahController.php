<?php

namespace App\Http\Controllers;

use App\Models\Ibadah;
use App\Models\IbadahDetail;
use App\Models\User;
use App\Traits\GuruTrait;
use App\Traits\InitTrait;
use EnumKehadiranIbadah;

class InputIbadahController extends Controller
{
    use InitTrait;
    use GuruTrait;

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
            'bulan' => 'required',
            'minggu' => 'required',
            'jenisIbadah' => 'required',
        ]);

        try {

            $ibadah = Ibadah::updateOrCreate(
                [
                    'tahun' => request('tahun'),
                    'bulan' => date('Y-' . request('bulan') . '-d'),
                    'minggu' => request('minggu'),
                    'jenis_ibadah' => request('jenisIbadah'),
                ]
            );

            $userBelumAbsensi = User::role(request('kategori'))
                ->whereJenisKelamin(request('jenisKelamin'))
                ->whereDoesntHave(
                    'ibadah_detail',
                    fn ($q) => $q->whereTahun(request('tahun'))
                        ->whereMonth('bulan', request('bulan'))
                        ->whereMinggu(request('minggu'))
                        ->whereJenisIbadah(request('jenisIbadah'))
                )
                ->get();

            foreach ($userBelumAbsensi as $user) {
                $ibadah->detail()->updateOrCreate(
                    [
                        'tahun' => request('tahun'),
                        'bulan' => date('Y-' . request('bulan') . '-d'),
                        'minggu' => request('minggu'),
                        'jenis_ibadah' => request('jenisIbadah'),
                        'user_id' => $user->id,
                    ],
                    [
                        'kehadiran_id' => EnumKehadiranIbadah::Hadir
                    ]
                );
            }

            return to_route('input-ibadah');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function simpan()
    {

        request()->validate([
            'tahun' => 'required',
            'bulan' => 'required',
            'minggu' => 'required',
            'jenisIbadah' => 'required',
        ]);

        $ibadah = Ibadah::updateOrCreate(
            [
                'tahun' => request('tahun'),
                'bulan' => date('Y-' . request('bulan') . '-d'),
                'minggu' => request('minggu'),
                'jenis_ibadah' => request('jenisIbadah'),
            ]
        );

        IbadahDetail::updateOrCreate(
            ['id' => request('id')],
            [
                'ibadah_id' => request('ibadahId') ?? $ibadah->id,
                'tahun' => request('tahun'),
                'bulan' => date('Y-' . request('bulan') . '-d'),
                'minggu' => request('minggu'),
                'jenis_ibadah' => request('jenisIbadah'),
                'user_id' => request('userId'),
                'kehadiran_id' => request('kehadiranId')
            ]
        );

        return response()->json([
            'listUser' => $this->data_absensi_ibadah(),
            'message' => 'Tersimpan',
            'id' => request('userId')
        ]);
    }
}
