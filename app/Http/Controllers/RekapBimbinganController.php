<?php

namespace App\Http\Controllers;

use App\Models\Bk;
use App\Models\BkDetail;
use App\Traits\InitTrait;

class RekapBimbinganController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia('Guru/RekapBimbingan', [
            'initTahun' => $this->data_tahun(),
        ]);
    }

    public function hapus()
    {
        $bkDetail = BkDetail::find(request('id'));

        Bk::destroy($bkDetail->bk_id);

        BkDetail::whereIn('bk_id', [$bkDetail->bk_id])->delete();

        return to_route('rekap-bimbingan');
    }
}
