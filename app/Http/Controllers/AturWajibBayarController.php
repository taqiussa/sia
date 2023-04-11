<?php

namespace App\Http\Controllers;

use App\Traits\InitTrait;
use App\Models\WajibBayar;

use function App\Helpers\ambilAngka;

class AturWajibBayarController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Bendahara/AturWajibBayar',
            [
                'initTahun' => $this->data_tahun()
            ]
        );
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'tingkat' => 'required',
            'jumlah' => 'required'
        ]);

        WajibBayar::create([
            'tahun' => request('tahun'),
            'tingkat' => request('tingkat'),
            'jumlah' => ambilAngka(request('jumlah'))
        ]);

        return to_route('atur-wajib-bayar');
    }

    public function hapus()
    {
        WajibBayar::destroy(request('id'));

        return to_route('atur-wajib-bayar');
    }
}
