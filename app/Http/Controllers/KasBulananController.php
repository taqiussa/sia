<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Traits\InitTrait;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\SwitchBulanTrait;

class KasBulananController extends Controller
{
    use InitTrait;
    use SwitchBulanTrait;

    public $bulanLalu;
    public $saldo;
    public $saldoLalu;
    public $tahunAwal;
    public $tahunAkhir;
    public $tanggalAwal;
    public $tanggalAkhir;

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Inisialisasi Bulan Lalu

        $currentMonth = Carbon::create(date('Y'), request('bulan'), 1, 0, 0, 0, 'Asia/Jakarta');

        $lastMonth = $currentMonth->subMonthNoOverflow()->format('m');

        $this->bulanLalu = $lastMonth;

        // Inisialisasi tahun dari tahun ajaran 

        $this->tahunAwal = Str::substr(request('tahun'), 0, 4);

        $this->tahunAkhir = Str::substr(request('tahun'), 7, 4);

        
        // Perhitungan
        
        $this->switch_bulan();
        
        $subtotalPemasukan = $this->subtotal_pemasukan();

        $totalPemasukanLalu = $this->total_pemasukan_lalu() + $this->total_pembayaran_lalu();

        $totalPengeluaran = $this->total_pengeluaran();

        $totalPengeluaranLalu = $this->total_pengeluaran_lalu();

        $totalSPP = $this->total_spp();

        $pemasukan = $this->pemasukan();

        $pengeluaran = $this->pengeluaran();

        if (request('bulan') == '07') {
            $this->saldoLalu = 0;
        } else {
            $this->saldoLalu = $totalPemasukanLalu - $totalPengeluaranLalu;
        }
        
        $this->saldo = $this->saldoLalu + $totalSPP + $subtotalPemasukan - $totalPengeluaran;

        return inertia(
            'Bendahara/KasBulanan',
            [
                'bulanLalu' => $this->bulanLalu,
                'initTahun' => $this->data_tahun(),
                'listPemasukan' => $pemasukan,
                'listPengeluaran' => $pengeluaran,
                'saldo' => $this->saldo,
                'saldoLalu' => $this->saldoLalu,
                'totalSPP' => $totalSPP,
                'totalPemasukan' => $totalSPP + $subtotalPemasukan,
                'totalPengeluaran' => $totalPengeluaran,
            ]
        );
    }
}
