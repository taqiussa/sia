<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
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
use App\Models\Gunabayar;
use App\Models\KepalaSekolah;
use App\Models\WaliKelas;

class BendaharaPrintController extends Controller
{
    use SwitchBulanTrait;

    public $bulanLalu;
    public $saldo;
    public $saldoLalu;
    public $tahunAwal;
    public $tahunAkhir;
    public $tanggalAwal;
    public $tanggalAkhir;

    public function kwitansi()
    {
        $id = request('id');
        $nis = request('nis');
        $tahun = request('tahun');

        $siswa = Siswa::whereTahun($tahun)
            ->whereNis($nis)
            ->with([
                'kelas' => fn ($q) => $q->select('id', 'nama'),
                'user' => fn ($q) => $q->select('nis', 'name')
            ])
            ->first();

        $pembayaran = Pembayaran::with('gunabayar')->where('transaksi_id', $id)->get();
        $wajibbayar = WajibBayar::where('tingkat', $siswa->tingkat)->where('tahun', $tahun)->first()->jumlah;
        $totalbayar = Pembayaran::where('nis', $nis)->where('tahun', $tahun)->sum('jumlah');
        $kurangbayar = $wajibbayar - $totalbayar;
        $transaksi = Transaksi::with(['user' => fn ($q) => $q->select('id', 'name')])->find($id);
        $data = [
            'list_pembayaran' => $pembayaran,
            'kelas' => $siswa->kelas->nama,
            'siswa' => $siswa->user->name,
            'tahun' => $tahun,
            'transaksi' => $transaksi,
            'wajibbayar' => $wajibbayar,
            'totalbayar' => $totalbayar,
            'kurangbayar' => $kurangbayar
        ];
        return view('print.bendahara.kwitansi', $data);
    }

    // Kas Print
    public function kas_bulanan_print()
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

        $data = [
            'kepalaSekolah' => KepalaSekolah::whereTahun(request('tahun'))
                ->with(['user' => fn ($q) => $q->select('id', 'name')])
                ->first()
                ->user
                ->name,
            'bulanLalu' => $this->bulanLalu,
            'listPemasukan' => $pemasukan ?? [],
            'listPengeluaran' => $pengeluaran ?? [],
            'saldo' => $this->saldo,
            'saldoLalu' => $this->saldoLalu,
            'totalSPP' => $totalSPP,
            'totalPemasukan' => $totalSPP + $subtotalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
        ];
        return view('print.bendahara.kas-bulanan', $data);
    }

    public function kas_tahunan_print()
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

        $data = [
            'kepalaSekolah' => KepalaSekolah::whereTahun(request('tahun'))
                ->with(['user' => fn ($q) => $q->select('id', 'name')])
                ->first()
                ->user
                ->name,
            'listPemasukan' => $pemasukan ?? [],
            'listPengeluaran' => $pengeluaran ?? [],
            'saldo' => $totalPemasukan - $totalPengeluaran,
            'totalSPP' => $totalSPP,
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran
        ];
        return view('print.bendahara.kas-tahunan', $data);
    }

    // Rekap Pemasukan

    public function rekap_harian_pemasukan_detail()
    {
        $subtotalPemasukan = Pemasukan::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])->sum('jumlah');
        $subtotalPembayaran = Pembayaran::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])->sum('jumlah');
        $total = $subtotalPembayaran + $subtotalPemasukan;
        $data = [
            'kepalaSekolah' => KepalaSekolah::whereTahun(request('tahun'))
                ->with(['user' => fn ($q) => $q->select('id', 'name')])
                ->first()
                ->user
                ->name,
            'tanggalAwal' => request('tanggalAwal'),
            'tanggalAkhir' => request('tanggalAkhir'),
            'listPembayaran' => Pembayaran::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])
                ->with([
                    'gunabayar',
                    'kelas',
                    'siswa',
                    'user'
                ])
                ->get(),
            'subtotalPembayaran' => $subtotalPembayaran,
            'listPemasukan' => Pemasukan::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])
                ->with([
                    'kategori',
                    'user'
                ])
                ->get(),
            'subtotalPemasukan' => $subtotalPemasukan,
            'total' => $total,
        ];
        return view('print.bendahara.rekap-harian-pemasukan-detail', $data);
    }

    public function rekap_harian_pemasukan_simple()
    {
        $subtotalPemasukan = Pemasukan::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])->sum('jumlah');
        $subtotalPembayaran = Pembayaran::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])->sum('jumlah');
        $total = $subtotalPembayaran + $subtotalPemasukan;
        $data = [
            'kepalaSekolah' => KepalaSekolah::whereTahun(request('tahun'))
                ->with(['user' => fn ($q) => $q->select('id', 'name')])
                ->first()
                ->user
                ->name,
            'tanggalAwal' => request('tanggalAwal'),
            'tanggalAkhir' => request('tanggalAkhir'),
            'subtotalPembayaran' => $subtotalPembayaran,
            'listKategori' => KategoriPemasukan::where('nama', '!=', 'SPP')
                ->with(['pemasukan' => fn ($q) => $q->whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])])
                ->orderBy('nama')->get(),
            'total' => $total,
        ];
        return view('print.bendahara.rekap-harian-pemasukan-simple', $data);
    }

    public function rekap_tahunan_pemasukan_detail()
    {
        $subtotalPemasukan = Pemasukan::whereTahun(request('tahun'))->sum('jumlah');
        $subtotalPembayaran = Pembayaran::whereTahun(request('tahun'))->sum('jumlah');
        $total = $subtotalPembayaran + $subtotalPemasukan;
        $data = [
            'kepalaSekolah' => KepalaSekolah::whereTahun(request('tahun'))
                ->with(['user' => fn ($q) => $q->select('id', 'name')])
                ->first()
                ->user
                ->name,
            'tahun' => request('tahun'),
            'listPembayaran' => Pembayaran::whereTahun(request('tahun'))
                ->with([
                    'gunabayar',
                    'kelas',
                    'siswa',
                    'user'
                ])
                ->get(),
            'subtotalPembayaran' => $subtotalPembayaran,
            'listPemasukan' => Pemasukan::whereTahun(request('tahun'))
                ->with([
                    'kategori',
                    'user'
                ])
                ->get(),
            'subtotalPemasukan' => $subtotalPemasukan,
            'total' => $total,
        ];
        return view('print.bendahara.rekap-tahunan-pemasukan-detail', $data);
    }

    public function rekap_tahunan_pemasukan_simple()
    {
        $subtotalPemasukan = Pemasukan::whereTahun(request('tahun'))->sum('jumlah');
        $subtotalPembayaran = Pembayaran::whereTahun(request('tahun'))->sum('jumlah');
        $total = $subtotalPembayaran + $subtotalPemasukan;
        $data = [
            'kepalaSekolah' => KepalaSekolah::whereTahun(request('tahun'))
                ->with(['user' => fn ($q) => $q->select('id', 'name')])
                ->first()
                ->user
                ->name,
            'tahun' => request('tahun'),
            'subtotalPembayaran' => $subtotalPembayaran,
            'listKategori' => KategoriPemasukan::where('nama', '!=', 'SPP')
                ->with(['pemasukan' => fn ($q) => $q->whereTahun(request('tahun'))])
                ->orderBy('nama')->get(),
            'total' => $total,
        ];
        return view('print.bendahara.rekap-tahunan-pemasukan-simple', $data);
    }

    // Rekap Pengeluaran
    public function rekap_harian_pengeluaran_detail()
    {
        $pengeluaran =  Pengeluaran::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])
            ->with([
                'kategori',
                'user'
            ])
            ->get();
        $data = [
            'kepalaSekolah' => KepalaSekolah::whereTahun(request('tahun'))
                ->with(['user' => fn ($q) => $q->select('id', 'name')])
                ->first()
                ->user
                ->name,
            'tanggalAwal' => request('tanggalAwal'),
            'tanggalAkhir' => request('tanggalAkhir'),
            'listPengeluaran' => $pengeluaran,
            'total' => $pengeluaran->sum('jumlah'),
        ];
        return view('print.bendahara.rekap-harian-pengeluaran-detail', $data);
    }

    public function rekap_harian_pengeluaran_simple()
    {
        $pengeluaran = Pengeluaran::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])->get();
        $data = [
            'kepalaSekolah' => KepalaSekolah::whereTahun(request('tahun'))
                ->with(['user' => fn ($q) => $q->select('id', 'name')])
                ->first()
                ->user
                ->name,
            'tanggalAwal' => request('tanggalAwal'),
            'tanggalAkhir' => request('tanggalAkhir'),
            'listKategori' => KategoriPengeluaran::withWhereHas(
                'pengeluaran',
                fn ($q) => $q->whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])
                    ->where('jumlah', '>', 0)
            )
                ->get(),
            'listPengeluaran' => $pengeluaran,
            'total' => $pengeluaran->sum('jumlah'),
        ];
        return view('print.bendahara.rekap-harian-pengeluaran-simple', $data);
    }

    public function rekap_tahunan_pengeluaran_detail()
    {
        $total = Pengeluaran::whereTahun(request('tahun'))->sum('jumlah');
        $data = [
            'kepalaSekolah' => KepalaSekolah::whereTahun(request('tahun'))
                ->with(['user' => fn ($q) => $q->select('id', 'name')])
                ->first()
                ->user
                ->name,
            'tahun' => request('tahun'),
            'listPengeluaran' => Pengeluaran::whereTahun(request('tahun'))
                ->with([
                    'kategori',
                    'user'
                ])
                ->get(),
            'total' => $total,
        ];
        return view('print.bendahara.rekap-tahunan-pengeluaran-detail', $data);
    }

    public function rekap_tahunan_pengeluaran_simple()
    {
        $total = Pengeluaran::whereTahun(request('tahun'))->sum('jumlah');
        $data = [
            'kepalaSekolah' => KepalaSekolah::whereTahun(request('tahun'))
                ->with(['user' => fn ($q) => $q->select('id', 'name')])
                ->first()
                ->user
                ->name,
            'tahun' => request('tahun'),
            'listKategori' => KategoriPengeluaran::withWhereHas(
                'pengeluaran',
                fn ($q) => $q->whereTahun(request('tahun'))
                    ->where('jumlah', '>', 0)
            )
                ->get(),
            'total' => $total,
        ];
        return view('print.bendahara.rekap-tahunan-pengeluaran-simple', $data);
    }

    // Tagihan Siswa
    public function rekap_per_siswa_print()
    {
        $gunabayar = Gunabayar::get();

        $siswa = Siswa::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->whereNis(request('nis'))
            ->with(
                [
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'pembayarans' => fn ($q) => $q->whereTahun(request('tahun')),
                    'user' => fn ($q) => $q->select('nis', 'name')
                ]
            )
            ->first();

        $wajibBayar = WajibBayar::whereTahun(request('tahun'))
            ->whereTingkat($siswa->tingkat)
            ->value('jumlah');

        $data = [
            'kepalaSekolah' => KepalaSekolah::whereTahun(request('tahun'))
                ->with(['user' => fn ($q) => $q->select('id', 'name')])
                ->first()
                ->user
                ->name,
            'listGunabayar' => $gunabayar,
            'siswa' => $siswa,
            'tahun' => request('tahun'),
            'wajibBayar' => $wajibBayar,
            'jumlah' => $wajibBayar / 12
        ];

        return view('print.bendahara.rekap-per-siswa-print', $data);
    }

    public function tagihan_per_kelas_print()
    {
        $gunabayar = Gunabayar::orderBy('semester')
            ->orderBy('id')
            ->get();

        $siswa = Siswa::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with(
                [
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'pembayarans' => fn ($q) => $q->whereTahun(request('tahun')),
                    'user' => fn ($q) => $q->select('nis', 'name')
                ]
            )
            ->get()
            ->sortBy('user.name')
            ->values();

        $waliKelas = WaliKelas::whereTahun(request('tahun'))
            ->whereKelasId(request('kelasId'))
            ->with([
                'kelas' => fn ($q) => $q->select('id', 'nama'),
                'user' => fn ($q) => $q->select('id', 'name')
            ])
            ->first();

        $data = [
            'kepalaSekolah' => KepalaSekolah::whereTahun(request('tahun'))
                ->with(['user' => fn ($q) => $q->select('id', 'name')])
                ->first()
                ->user
                ->name,
            'listGunabayar' => $gunabayar,
            'listSiswa' => $siswa,
            'namaKelas' => $waliKelas->kelas->nama,
            'namaWaliKelas' => $waliKelas->user->name,
            'siswa' => $siswa,
            'tahun' => request('tahun'),
        ];

        return view('print.bendahara.tagihan-per-kelas-print', $data);
    }
}
