<?php

namespace App\Http\Controllers;

use App\Models\AturanPulangSpesial;
use App\Models\User;
use App\Traits\InitTrait;

class AturPulangSpesialController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia('Guru/AturPulangSpesial', [
            'initTahun' => $this->data_tahun(),
            'listUser' => User::whereNotNull('username')
                ->whereIsActive(true)
                ->orderBy('name')
                ->get()
        ]);
    }

    public function simpan()
    {
        $validate = request()->validate([
            'tahun' => 'required',
            'user_id' => 'required',
            'keterangan' => 'required',
            'tanggal' => 'required'
        ]);

        AturanPulangSpesial::create($validate);

        return to_route('atur-pulang-spesial');
    }

    public function hapus()
    {
        AturanPulangSpesial::destroy(request('id'));

        return to_route('atur-pulang-spesial');
    }
}
