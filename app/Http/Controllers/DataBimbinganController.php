<?php

namespace App\Http\Controllers;

use App\Models\BkDetail;
use App\Traits\InitTrait;

class DataBimbinganController extends Controller
{

    use InitTrait;

    public function index()
    {
        return inertia(
            'Siswa/DataBimbingan',
            [
                'initTahun' => $this->data_tahun()
            ]
        );
    }

    public function detail()
    {
        return inertia(
            'Siswa/DetailBimbingan',
            [
                'bimbingan' => BkDetail::with([
                    'bk.user' => fn ($q) => $q->select('id', 'name'),
                    'user' => fn ($q) => $q->select('nis', 'name')
                ])
                    ->find(request('id'))
            ]
        );
    }
}
