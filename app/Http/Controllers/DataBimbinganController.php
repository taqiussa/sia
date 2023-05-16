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
                'listBimbingan' => BkDetail::whereTahun($this->data_tahun())
                    ->whereNis(auth()->user()->nis)
                    ->with(['user' => fn ($q) => $q->select('id', 'name')])
                    ->get()
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
