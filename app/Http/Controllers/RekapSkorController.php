<?php

namespace App\Http\Controllers;

use App\Models\PenilaianSkor;
use App\Models\User;
use App\Traits\InitTrait;
use Inertia\Inertia;

class RekapSkorController extends Controller
{
    use InitTrait;

    public function index()
    {
        $nis = User::when(request('search'), fn ($q) => $q->where('name', 'like', '%' . request('search') . '%'))
            ->pluck('nis');

        $skor = PenilaianSkor::when(request('tahun'), fn ($q) => $q->whereTahun(request('tahun')))
            ->whereIn('nis', $nis)
            ->with([
                'kelas',
                'siswa',
                'skors',
                'user'
            ])
            ->latest()
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($q) => [
                'id' => $q->id,
                'tanggal' => $q->tanggal,
                'siswa' => $q->siswa,
                'skors' => $q->skors,
                'user' => $q->user
            ]);

        return inertia(
            'Guru/RekapSkor',
            [
                'initTahun' => $this->data_tahun(),
                'listRekapSkor' => $skor,
                'filters' => request()->only('search')
            ]
        );
    }

    public function hapus()
    {
        PenilaianSkor::destroy(request('id'));

        return to_route('rekap-skor');
    }
}
