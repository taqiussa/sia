<?php

namespace App\Http\Controllers;

use App\Models\AbsensiKaryawan;
use App\Models\AturanKhususPulang;
use App\Models\AturanPulangAwal;
use App\Models\AturanPulangSpesial;
use App\Models\AturanTransport;
use App\Models\RekapTransport;
use App\Models\User;
use App\Traits\InitTrait;
use Carbon\Carbon;

class ProsesTransportController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia('Guru/ProsesTransport', [
            'initTahun' => $this->data_tahun(),
            'listUser' => User::whereNotNull('username')
                ->whereIsActive(true)
                ->orderBy('name')
                ->get()
        ]);
    }

    public function simpan()
    {

        request()->validate([
            'tahun' => 'required',
            'bulan' => 'required',
            'tanggalAwal' => 'required',
            'tanggalAkhir' => 'required',
            'userId' => 'required'
        ]);

        AturanTransport::updateOrCreate(
            [
                'tahun' => request('tahun'),
                'bulan' => request('bulan')
            ],
            [
                'tanggal_awal' => request('tanggalAwal'),
                'tanggal_akhir' => request('tanggalAkhir')
            ]
        );

        $listAbsensi = AbsensiKaryawan::whereUserId(request('userId'))
            ->whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])
            ->get();


        $listUserKhusus = AturanKhususPulang::whereTahun(request('tahun'))
            ->whereUserId(request('userId'))
            ->get();

        $aturanPulangAwal = AturanPulangAwal::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])
            ->get();


        if (!blank(($listUserKhusus))) {

            foreach ($listAbsensi as $absensi) {

                $transport = 1;

                $jamMasuk = Carbon::parse($absensi->tanggal . ' 7:00:59');

                $jamPulang = Carbon::parse($absensi->tanggal . ' 13:00:00');


                $jamPulangAwal = $aturanPulangAwal->where('tanggal', $absensi->tanggal)->first();

                $masuk = Carbon::parse($absensi->masuk);

                $pulang = $absensi->pulang ? Carbon::parse($absensi->pulang) : null;

                $aturanPulang = $jamPulangAwal ?  Carbon::parse($jamPulangAwal->pulang) : null;

                $isJumat = Carbon::parse($absensi->tanggal)->isFriday();

                $jamPulangJumat = Carbon::parse($absensi->tanggal . ' 10:30:00');

                $hariTanggalIni = Carbon::parse($listAbsensi->where('tanggal', $absensi->tanggal)->first()->tanggal)->dayOfWeek;

                if (in_array($hariTanggalIni, $listUserKhusus->pluck('hari')->toArray())) {

                    $jamPulangKhusus = Carbon::parse($absensi->tanggal .  $listUserKhusus->first()->jam);

                    if ($masuk->greaterThan($jamMasuk) || (!$jamPulangAwal && $pulang->lessThan($jamPulangKhusus)) || ($jamPulangAwal && $pulang->lessThan($aturanPulang))) {
                        $transport = 0;
                    }
                } else {
                    if ($isJumat) {
                        if ($masuk->greaterThan($jamMasuk) || $pulang->lessThan($jamPulangJumat) || ($jamPulangAwal && $pulang->lessThan($aturanPulang))) {
                            $transport = 0;
                        }
                    } else {
                        if ($masuk->greaterThan($jamMasuk) || $pulang->lessThan($jamPulang) || ($jamPulangAwal && $pulang->lessThan($aturanPulang))) {
                            $transport = 0;
                        }
                    }
                }


                RekapTransport::updateOrCreate(
                    [
                        'tanggal' => $absensi->tanggal,
                    ],
                    [
                        'user_id' => request('userId'),
                        'tahun' => request('tahun'),
                        'bulan' => request('bulan'),
                        'hadir' => 1,
                        'transport' => $transport
                    ]
                );
            }
        } else {
            foreach ($listAbsensi as $absensi) {

                $transport = 1;

                $jamMasuk = Carbon::parse($absensi->tanggal . ' 7:00:59');

                $jamPulang = Carbon::parse($absensi->tanggal . ' 13:00:00');

                $jamPulangAwal = $aturanPulangAwal->where('tanggal', $absensi->tanggal)->first();

                $masuk = Carbon::parse($absensi->masuk);

                $pulang = $absensi->pulang ? Carbon::parse($absensi->pulang) : null;

                $aturanPulang = $jamPulangAwal ?  Carbon::parse($jamPulangAwal->pulang) : null;

                $isJumat = Carbon::parse($absensi->tanggal)->isFriday();

                $jamPulangJumat = Carbon::parse($absensi->tanggal . ' 10:30:00');

                if ($isJumat) {
                    if ($jamPulangAwal && ($pulang->lessThan($aturanPulang) || $masuk->greaterThan($jamMasuk))) {
                        $transport = 0;
                    } else if ($masuk->greaterThan($jamMasuk) || $pulang->lessThan($jamPulangJumat)) {
                        $transport = 0;
                    } else {
                        $transport = 1;
                    }
                } else {
                    if ($jamPulangAwal && ($pulang->lessThan($aturanPulang) || $masuk->greaterThan($jamMasuk))) {
                        $transport = 0;
                    } else if ($masuk->greaterThan($jamMasuk) || $pulang->lessThan($jamPulang)) {
                        $transport = 0;
                    } else {
                        $transport = 1;
                    }
                }

                RekapTransport::updateOrCreate(
                    [
                        'tanggal' => $absensi->tanggal,
                    ],
                    [
                        'user_id' => request('userId'),
                        'tahun' => request('tahun'),
                        'bulan' => request('bulan'),
                        'hadir' => 1,
                        'transport' => $transport
                    ]
                );
            }
        }

        $listUserSpesial = AturanPulangSpesial::whereUserId(request('userId'))
            ->whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])
            ->get();

        if (!blank($listUserSpesial)) {
            foreach ($listUserSpesial as $spesial) {
                RekapTransport::whereTanggal($spesial->tanggal)
                    ->whereUserId(request('userId'))
                    ->update([
                        'transport' => 1
                    ]);
            }
        }



        return to_route('proses-transport');
    }
}
