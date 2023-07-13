<?php

namespace App\Http\Controllers;

use App\Models\AturanKhususPulang;
use App\Models\User;
use App\Traits\InitTrait;

class AturKhususPulangController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/AturKhususPulang',
            [
                'initTahun' => $this->data_tahun(),
                'listUser' => User::role(['Guru', 'Karyawan'])
                    ->orderBy('name')
                    ->get()
            ]
        );
    }

    public function simpan()
    {
        $validate = request()->validate([
            'user_id' => 'required',
            'tahun' => 'required',
            'hari' => 'required',
            'jam' => 'required',
        ]);

        AturanKhususPulang::create($validate);

        return to_route('atur-khusus-pulang');
    }

    public function hapus()
    {
        AturanKhususPulang::destroy(request('id'));

        return to_route('atur-khusus-pulang');
    }
}
