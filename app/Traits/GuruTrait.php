<?php

namespace App\Traits;

use App\Models\User;

trait GuruTrait
{
    public function data_absensi_ibadah()
    {
        return User::role(request('kategori'))
            ->whereJenisKelamin(request('jenisKelamin'))
            ->with([
                'ibadah_detail' => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereMonth('bulan', request('bulan'))
                    ->whereMinggu(request('minggu'))
                    ->whereJenisIbadah(request('jenisIbadah'))
            ])
            ->orderBy('name')
            ->get();
    }

    public function data_absensi_ibadahs()
    {
        return User::role(request('kategori'))
            ->whereJenisKelamin(request('jenisKelamin'))
            ->with([
                'ibadah_details' => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereMonth('bulan', request('bulan'))
                    ->whereJenisIbadah(request('jenisIbadah'))
            ])
            ->orderBy('name')
            ->get();
    }

    public function data_absensi_sosial()
    {
        return User::role(request('role'))
            ->whereJenisKelamin(request('jenisKelamin'))
            ->with([
                'sosial_detail' => fn ($q) => $q->whereTanggal(request('tanggal'))
            ])
            ->orderBy('name')
            ->get();
    }

    public function data_absensi_sosials()
    {
        return User::role(request('role'))
            ->whereJenisKelamin(request('jenisKelamin'))
            ->with([
                'sosial_details' => fn ($q) => $q->whereTahun(request('tahun'))
            ])
            ->orderBy('name')
            ->get();
    }
}
