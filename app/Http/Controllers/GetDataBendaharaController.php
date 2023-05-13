<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Pemasukan;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use App\Models\WajibBayar;
use App\Models\Pengeluaran;
use Illuminate\Support\Str;
use App\Traits\SwitchBulanTrait;
use App\Models\KategoriPemasukan;
use App\Models\KategoriPengeluaran;
use App\Http\Controllers\Controller;

class GetDataBendaharaController extends Controller
{
    use SwitchBulanTrait;

    public $bulanLalu;
    public $saldo;
    public $saldoLalu;
    public $tahunAwal;
    public $tahunAkhir;
    public $tanggalAwal;
    public $tanggalAkhir;

    public function get_kas_bulanan()
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

        return response()->json(
            [
                'bulanLalu' => $this->bulanLalu,
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

    public function get_kas_tahunan()
    {
        $pemasukan = KategoriPemasukan::withWhereHas(
            'pemasukan',
            fn ($q) => $q->whereTahun(request('tahun'))
                ->where('jumlah', '>', 0)
        )
            ->get();

        $pengeluaran = KategoriPengeluaran::withWhereHas(
            'pengeluaran',
            fn ($q) => $q->whereTahun(request('tahun'))
                ->where('jumlah', '>', 0)
        )
            ->get();

        $totalSPP = Pembayaran::whereTahun(request('tahun'))
            ->sum('jumlah');

        $totalPemasukan = Pemasukan::whereTahun(request('tahun'))
            ->sum('jumlah') + $totalSPP;

        $totalPengeluaran = Pengeluaran::whereTahun(request('tahun'))
            ->sum('jumlah');

        return response()->json([
            'listPemasukan' => $pemasukan,
            'listPengeluaran' => $pengeluaran,
            'saldo' => $totalPemasukan - $totalPengeluaran,
            'totalSPP' => $totalSPP,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran
        ]);
    }

    public function get_pemasukan()
    {
        return response()->json([
            'listPemasukan' => Pemasukan::whereTahun(request('tahun'))
                ->with([
                    'kategori' => fn ($q) => $q->select('id', 'nama'),
                    'user' => fn ($q) => $q->select('id', 'name')
                ])
                ->latest()
                ->get()
        ]);
    }

    public function get_pemasukan_harian()
    {
        $pembayaran = Pembayaran::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])
            ->with([
                'gunabayar' => fn ($q) => $q->select('id', 'nama'),
                'kelas' => fn ($q) => $q->select('id', 'nama'),
                'siswa' => fn ($q) => $q->select('nis', 'name'),
                'user' => fn ($q) => $q->select('id', 'name'),
            ]);

        return response()->json([
            'listPemasukan' => Pemasukan::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])
                ->with([
                    'kategori' => fn ($q) => $q->select('id', 'nama'),
                    'user' => fn ($q) => $q->select('id', 'name')
                ])
                ->latest()
                ->get(),
            'listPembayaran' => $pembayaran->get(),
            'subtotalPembayaran' => $pembayaran->sum('jumlah')
        ]);
    }

    public function get_pembayaran()
    {
        return response()->json([
            'listPembayaran' => Transaksi::whereTahun(request('tahun'))
                ->with([
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'siswa' => fn ($q) => $q->select('nis', 'name'),
                    'user' => fn ($q) => $q->select('id', 'name'),
                ])
                ->latest()
                ->get()
        ]);
    }

    public function get_pembayaran_custom()
    {
        return response()->json([
            'listPembayaran' => Transaksi::whereTahun(request('tahun'))
                ->with([
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'siswa' => fn ($q) => $q->select('nis', 'name'),
                    'user' => fn ($q) => $q->select('id', 'name'),
                ])
                ->latest()
                ->paginate(10)
        ]);
    }


    public function get_pembayaran_siswa()
    {
        $siswa =  Siswa::whereTahun(request('tahun'))
            ->whereNis(request('nis'))
            ->with([
                'alamat',
                'alamat.provinsi',
                'kelas' => fn ($q) => $q->select('id', 'nama'),
                'pembayarans' => fn ($q) => $q->whereTahun(request('tahun')),
                'pembayarans.user' => fn ($q) => $q->select('id', 'name'),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
            ->withSum([
                'transaksis as totalBayar' => fn ($q) => $q->whereTahun(request('tahun'))
            ], 'jumlah')
            ->first();

        $wajibBayar = WajibBayar::whereTahun(request('tahun'))
            ->whereTingkat($siswa->tingkat)
            ->value('jumlah');

        return response()->json([
            'dataSiswa' => $siswa,
            'listPembayaran' => Transaksi::whereTahun(request('tahun'))
                ->whereNis(request('nis'))
                ->with([
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'user' => fn ($q) => $q->select('id', 'name')
                ])
                ->latest()
                ->get(),
            'wajibBayar' => $wajibBayar,
            'jumlah' => $wajibBayar / 12
        ]);
    }

    public function get_pengeluaran()
    {
        return response()->json([
            'listPengeluaran' => Pengeluaran::whereTahun(request('tahun'))
                ->with([
                    'kategori' => fn ($q) => $q->select('id', 'nama'),
                    'user' => fn ($q) => $q->select('id', 'name')
                ])
                ->latest()
                ->get()
        ]);
    }

    public function get_wajib_bayar()
    {
        return response()->json([
            'listWajibBayar' => WajibBayar::whereTahun(request('tahun'))
                ->get()
        ]);
    }
}
