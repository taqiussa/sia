<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Pemasukan;
use App\Models\Pembayaran;
use App\Models\Pengeluaran;
use App\Models\KategoriPemasukan;
use App\Models\KategoriPengeluaran;

trait SwitchBulanTrait
{
    public function pemasukan()
    {
        return KategoriPemasukan::withWhereHas(
            'pemasukan',
            fn ($q) => $q->whereTahun(request('tahun'))
                ->whereMonth('tanggal', request('bulan'))
                ->where('jumlah', '>', 0)
        )
            ->get();
    }

    public function pengeluaran()
    {
        return KategoriPengeluaran::withWhereHas(
            'pengeluaran',
            fn ($q) => $q->whereTahun(request('tahun'))
                ->whereMonth('tanggal', request('bulan'))
                ->where('jumlah', '>', 0)
        )
            ->get();
    }

    public function subtotal_pemasukan()
    {
        return Pemasukan::whereTahun(request('tahun'))
            ->whereMonth('tanggal', request('bulan'))
            ->sum('jumlah');
    }

    public function switch_bulan()
    {
        switch (request('bulan')) {
            case '07':
                $this->juli();
                break;
            case '08':
                $this->agustus();
                break;
            case '09':
                $this->september();
                break;
            case '10':
                $this->oktober();
                break;
            case '11':
                $this->november();
                break;
            case '12':
                $this->desember();
                break;
            case '01':
                $this->januari();
                break;
            case '02':
                $this->februari();
                break;
            case '03':
                $this->maret();
                break;
            case '04':
                $this->april();
                break;
            case '05':
                $this->mei();
                break;
            case '06':
                $this->juni();
                break;
            default:
                $this->saldoLalu = 0;
                break;
        }
    }

    public function total_pemasukan_lalu()
    {
        return  Pemasukan::whereBetween('tanggal', [$this->tanggalAwal, $this->tanggalAkhir])->sum('jumlah');
    }

    public function total_pembayaran_lalu()
    {
        return Pembayaran::whereBetween('tanggal', [$this->tanggalAwal, $this->tanggalAkhir])->sum('jumlah');
    }

    public function total_pengeluaran()
    {
        return Pengeluaran::whereTahun(request('tahun'))
            ->whereMonth('tanggal', request('bulan'))
            ->sum('jumlah');
    }

    public function total_pengeluaran_lalu()
    {
        return Pengeluaran::whereBetween('tanggal', [$this->tanggalAwal, $this->tanggalAkhir])->sum('jumlah');
    }

    public function total_spp()
    {
        return Pembayaran::whereTahun(request('tahun'))
            ->whereMonth('tanggal', request('bulan'))
            ->sum('jumlah');
    }


    // Initialisasi tanggal awal dan akhir untuk bulan lalu 
    private function agustus()
    {
        //inisialisasi tanggal awal dan tanggal akhir
        $this->tanggalAwal = Carbon::createFromDate(date($this->tahunAwal . '-' . $this->bulanLalu . '-d'))
            ->startOfMonth();
        $this->tanggalAkhir = Carbon::createFromDate(date($this->tahunAwal . '-' . $this->bulanLalu . '-d'))
            ->endOfMonth();
    }

    private function september()
    {
        //inisialisasi tanggal awal dan tanggal akhir
        $this->tanggalAwal = Carbon::createFromDate(date($this->tahunAwal . '-07-d'))
            ->startOfMonth();
        $this->tanggalAkhir = Carbon::createFromDate(date($this->tahunAwal . '-08-d'))
            ->endOfMonth();
    }

    private function oktober()
    {
        //inisialisasi tanggal awal dan tanggal akhir
        $this->tanggalAwal = Carbon::createFromDate(date($this->tahunAwal . '-07-d'))
            ->startOfMonth();
        $this->tanggalAkhir = Carbon::createFromDate(date($this->tahunAwal . '-09-d'))
            ->endOfMonth();
    }

    private function november()
    {
        //inisialisasi tanggal awal dan tanggal akhir
        $this->tanggalAwal = Carbon::createFromDate(date($this->tahunAwal . '-07-d'))
            ->startOfMonth();
        $this->tanggalAkhir = Carbon::createFromDate(date($this->tahunAwal . '-10-d'))
            ->endOfMonth();
    }

    private function desember()
    {
        //inisialisasi tanggal awal dan tanggal akhir
        $this->tanggalAwal = Carbon::createFromDate(date($this->tahunAwal . '-07-d'))
            ->startOfMonth();
        $this->tanggalAkhir = Carbon::createFromDate(date($this->tahunAwal . '-11-d'))
            ->endOfMonth();
    }

    private function januari()
    {
        //inisialisasi tanggal awal dan tanggal akhir
        $this->tanggalAwal = Carbon::createFromDate(date($this->tahunAwal . '-07-d'))
            ->startOfMonth();
        $this->tanggalAkhir = Carbon::createFromDate(date($this->tahunAwal . '-12-d'))
            ->endOfMonth();
    }

    private function februari()
    {
        //inisialisasi tanggal awal dan tanggal akhir
        $this->tanggalAwal = Carbon::createFromDate(date($this->tahunAwal . '-07-d'))
            ->startOfMonth();
        $this->tanggalAkhir = Carbon::createFromDate(date($this->tahunAkhir . '-01-d'))
            ->endOfMonth();
    }

    private function maret()
    {
        //inisialisasi tanggal awal dan tanggal akhir
        $this->tanggalAwal = Carbon::createFromDate(date($this->tahunAwal . '-07-d'))
            ->startOfMonth();
        $this->tanggalAkhir = Carbon::createFromDate(date($this->tahunAkhir . '-02-d'))
            ->endOfMonth();
    }

    private function april()
    {
        //inisialisasi tanggal awal dan tanggal akhir
        $this->tanggalAwal = Carbon::createFromDate(date($this->tahunAwal . '-07-d'))
            ->startOfMonth();
        $this->tanggalAkhir = Carbon::createFromDate(date($this->tahunAkhir . '-03-d'))
            ->endOfMonth();
    }

    private function mei()
    {
        //inisialisasi tanggal awal dan tanggal akhir
        $this->tanggalAwal = Carbon::createFromDate(date($this->tahunAwal . '-07-d'))
            ->startOfMonth();
        $this->tanggalAkhir = Carbon::createFromDate(date($this->tahunAkhir . '-04-d'))
            ->endOfMonth();
    }

    private function juni()
    {
        //inisialisasi tanggal awal dan tanggal akhir
        $this->tanggalAwal = Carbon::createFromDate(date($this->tahunAwal . '-07-d'))
            ->startOfMonth();
        $this->tanggalAkhir = Carbon::createFromDate(date($this->tahunAkhir . '-05-d'))
            ->endOfMonth();
    }

    private function juli()
    {
        //inisialisasi tanggal awal dan tanggal akhir
        $this->tanggalAwal = Carbon::createFromDate(date($this->tahunAwal . '-07-d'))
            ->startOfMonth();
        $this->tanggalAkhir = Carbon::createFromDate(date($this->tahunAwal . '-07-d'))
            ->endOfMonth();
    }
}
