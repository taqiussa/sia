<?php

namespace App\Exports;

use App\Models\KategoriPenilaianGuru;
use App\Models\User;
use App\Models\WaliKelas;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportNilaiKaryawan implements FromView
{
    public function view(): View
    {
        $kategori = KategoriPenilaianGuru::find(request('kategoriNilaiId'))?->nama;

        if ($kategori == 'Guru') {
            $users = User::role('Guru')->orderBy('name')
                ->with(['penilaians'])
                ->get();
        } elseif ($kategori == 'Karyawan') {
            $users = User::role('Karyawan')->orderBy('name')
                ->with(['penilaians'])
                ->get();
        } else {
            $waliKelas = WaliKelas::whereTahun(request('tahun'))->pluck('user_id');
            $users = User::whereIn('id', $waliKelas)->orderBy('name')->get();
        }
        $data = [
            'tahun' => request('tahun'),
            'kategori_nilai_id' => request('kategoriNilaiId'),
            'jenis_penilaian_id' => request('jenisPenilaianId'),
            'listUser' => $users
        ];
        return view('export.export-nilai-karyawan', $data);
    }
}
