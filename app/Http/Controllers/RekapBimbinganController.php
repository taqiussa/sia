<?php

namespace App\Http\Controllers;

use App\Models\Bk;
use App\Models\BkDetail;
use App\Models\User;
use App\Traits\InitTrait;

class RekapBimbinganController extends Controller
{
    use InitTrait;

    public function index()
    {
        $user = User::when(request('search'), fn ($q) =>  $q->where('name', 'like', '%' . request('search') . '%'))
            ->get();

        $bkDetail = BkDetail::with(
            [
                'bk',
                'bk.user' => fn ($q) => $q->select('id', 'name'),
                'kelas' => fn ($q) => $q->select('id', 'nama'),
                'user' => fn ($q) => $q->select('nis', 'name')
            ]
        )
            ->whereHas('bk', fn ($q) => $q->whereBentukBimbingan(request('bentukBimbingan'))
                ->whereTahun(request('tahun')))
            ->whereIn('nis', $user->pluck('nis'))
            ->latest()
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($q) => [
                'id' => $q->id,
                'bk' => $q->bk,
                'bk.user' => $q->bk->user,
                'kelas' => $q->kelas,
                'user' => $q->user,
                'tanggal' => $q->tanggal,
                'bentuk_bimbingan' => $q->bentuk_bimbingan,
                'permasalahan' => $q->permasalahan,
                'tindak_lanjut' => $q->tindak_lanjut,
            ]);

        return inertia('Guru/RekapBimbingan', [
            'initTahun' => $this->data_tahun(),
            'listBimbingan' => $bkDetail,
            'filters' => request()->only('search')
        ]);
    }

    public function hapus()
    {
        $bkDetail = BkDetail::find(request('id'));

        Bk::destroy($bkDetail->bk_id);

        BkDetail::whereIn('bk_id', [$bkDetail->bk_id])->delete();

        return to_route(
            'rekap-bimbingan',
            [
                'tahun' => request('tahun'),
                'bentukBimbingan' => request('bentukBimbingan'),
                'search' => request('search')
            ]
        );
    }
}
