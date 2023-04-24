<?php

namespace App\Http\Controllers;

use App\Models\SiswaEkstra;
use App\Traits\InitTrait;
use Illuminate\Http\Request;

class DataSiswaEkstrakurikulerController extends Controller
{
    use InitTrait;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return inertia(
            'Guru/DataSiswaEkstrakurikuler',
            [
                'initTahun' => $this->data_tahun(),
                'filters' => request()->only('search'),
                'listSiswa' => SiswaEkstra::whereTahun(request('tahun'))
                    ->join('kelas', 'siswa_ekstras.kelas_id', '=', 'kelas.id')
                    ->join('users', 'siswa_ekstras.nis', '=', 'users.nis')
                    ->with([
                        'ekstrakurikuler' => fn ($q) => $q->select('id', 'nama'),
                        'kelas' => fn ($q) => $q->select('id', 'nama'),
                        'user' => fn ($q) => $q->select('nis', 'name')
                    ])
                    ->when(request('search'), fn ($q) => $q->withWhereHas('user', fn ($q) => $q->where('name', 'like', '%' . request('search') . '%')))
                    ->orderBy('kelas.nama')
                    ->orderBy('users.name')
                    ->paginate(10)
                    ->withQueryString()
                    ->through(fn ($q) => [
                        'id' => $q->id,
                        'ekstrakurikuler' => $q->ekstrakurikuler,
                        'kelas' => $q->kelas,
                        'user' => $q->user,
                    ])
            ]
        );
    }
}
