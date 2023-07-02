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
use DateTime;

class ProsesTransportController extends Controller
{
    use InitTrait;

    public $transport = 1;

    public function index()
    {
        return inertia('Guru/ProsesTransport', [
            'initTahun' => $this->data_tahun(),
            // 'listUser' => User::whereNotNull('username')
            //     ->whereIsActive(true)
            //     ->orderBy('name')
            //     ->get()
        ]);
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'bulan' => 'required',
            'tanggalAwal' => 'required',
            'tanggalAkhir' => 'required',
            // 'userId' => 'required',
            'pilihan' => 'required'
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

        if (request('pilihan') == 'Satpam') {
            $listUser = User::role('Satpam')
                ->get();
        } else {
            $listUser = User::role(['Tata Usaha', 'Guru', 'Kepala Sekolah', 'Bendahara'])
                ->get();
        }

        set_time_limit(0);

        foreach ($listUser as $user) {

            $listAbsensi = AbsensiKaryawan::whereUserId($user->id)
                ->whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])
                ->get();

            $listUserKhusus = AturanKhususPulang::whereTahun(request('tahun'))
                ->whereUserId($user->id)
                ->get();

            $aturanPulangAwal = AturanPulangAwal::whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])
                ->get();

            if (!blank(($listUserKhusus))) {

                foreach ($listAbsensi as $absensi) {

                    if (request('pilihan') == 'Satpam') {
                        $jamMasuk = new DateTime($absensi->tanggal . ' 6:15:59');
                    } else {
                        $jamMasuk = new DateTime($absensi->tanggal . ' 7:00:59');
                    }

                    if (request('pilihan') == 'Satpam') {
                        $jamPulang = new DateTime($absensi->tanggal . ' 13:30:00');
                    } else {

                        $jamPulang = new DateTime($absensi->tanggal . ' 13:00:00');
                    }

                    $jamPulangAwal = $aturanPulangAwal->where('tanggal', $absensi->tanggal)->first();

                    $masuk = new DateTime($absensi->masuk);

                    $pulang = $absensi->pulang ? new DateTime($absensi->pulang) : null;

                    $aturanPulang = $jamPulangAwal ?  new DateTime($jamPulangAwal->pulang) : null;

                    $isJumat = Carbon::parse($absensi->tanggal)->isFriday();

                    $jamPulangJumat = new DateTime($absensi->tanggal . ' 10:30:00');

                    $hariTanggalIni = Carbon::parse($listAbsensi->where('tanggal', $absensi->tanggal)->first()->tanggal)->dayOfWeek;

                    if (in_array($hariTanggalIni, $listUserKhusus->pluck('hari')->toArray())) {

                        $jamPulangKhusus = new DateTime($absensi->tanggal .  $listUserKhusus->first()->jam);

                        if ($masuk <= $jamMasuk && $absensi->pulang != null) {
                            if ($isJumat) {
                                if (!blank($jamPulangAwal)) {
                                    if ($pulang >= $aturanPulang) {
                                        $this->transport = 1;
                                    } else {
                                        $this->transport = 0;
                                    }
                                } else {
                                    if ($pulang >= $jamPulangJumat) {
                                        $this->transport = 1;
                                    } else {
                                        $this->transport = 0;
                                    }
                                }
                            } else {
                                if (!blank($jamPulangAwal)) {
                                    if ($pulang >= $aturanPulang) {
                                        $this->transport = 1;
                                    } else {
                                        $this->transport = 0;
                                    }
                                } else {
                                    if ($pulang >= $jamPulangKhusus) {
                                        $this->transport = 1;
                                    } else {
                                        $this->transport = 0;
                                    }
                                }
                            }
                        } else {
                            $this->transport = 0;
                        }
                    } else {
                        if ($masuk <= $jamMasuk && $absensi->pulang != null) {
                            if ($isJumat) {
                                if (!blank($jamPulangAwal)) {
                                    if ($pulang >= $aturanPulang) {
                                        $this->transport = 1;
                                    } else {
                                        $this->transport = 0;
                                    }
                                } else {
                                    if ($pulang >= $jamPulang) {
                                        $this->transport = 1;
                                    } else {
                                        $this->transport = 0;
                                    }
                                }
                            } else {
                                if (!blank($jamPulangAwal)) {
                                    if ($pulang >= $aturanPulang) {
                                        $this->transport = 1;
                                    } else {
                                        $this->transport = 0;
                                    }
                                } else {
                                    if ($pulang >= $jamPulang) {
                                        $this->transport = 1;
                                    } else {
                                        $this->transport = 0;
                                    }
                                }
                            }
                        } else {
                            $this->transport = 0;
                        }
                    }

                    RekapTransport::updateOrCreate(
                        [
                            'tanggal' => $absensi->tanggal,
                            'user_id' => $user->id,
                        ],
                        [
                            'tahun' => request('tahun'),
                            'bulan' => request('bulan'),
                            'hadir' => 1,
                            'transport' => $this->transport
                        ]
                    );
                }
            } else {
                foreach ($listAbsensi as $absensi) {

                    if (request('pilihan') == 'Satpam') {
                        $jamMasuk = new DateTime($absensi->tanggal . ' 6:15:59');
                    } else {
                        $jamMasuk = new DateTime($absensi->tanggal . ' 7:00:59');
                    }

                    if (request('pilihan') == 'Satpam') {
                        $jamPulang = new DateTime($absensi->tanggal . ' 13:30:00');
                    } else {

                        $jamPulang = new DateTime($absensi->tanggal . ' 13:00:00');
                    }

                    $jamPulangAwal = $aturanPulangAwal->where('tanggal', $absensi->tanggal)->first();

                    $masuk = new DateTime($absensi->masuk);

                    $pulang = $absensi->pulang ? new DateTime($absensi->pulang) : null;

                    $aturanPulang = $jamPulangAwal ?  new DateTime($jamPulangAwal->pulang) : null;

                    $isJumat = Carbon::parse($absensi->tanggal)->isFriday();

                    $jamPulangJumat = new DateTime($absensi->tanggal . ' 10:30:00');

                    if ($masuk <= $jamMasuk && $absensi->pulang != null) {
                        if ($isJumat) {
                            if (!blank($jamPulangAwal)) {
                                if ($pulang >= $aturanPulang) {
                                    $this->transport = 1;
                                } else {
                                    $this->transport = 0;
                                }
                            } else {
                                if ($pulang >= $jamPulangJumat) {
                                    $this->transport = 1;
                                } else {
                                    $this->transport = 0;
                                }
                            }
                        } else {
                            if (!blank($jamPulangAwal)) {
                                if ($pulang >= $aturanPulang) {
                                    $this->transport = 1;
                                } else {
                                    $this->transport = 0;
                                }
                            } else {
                                if ($pulang >= $jamPulang) {
                                    $this->transport = 1;
                                } else {
                                    $this->transport = 0;
                                }
                            }
                        }
                    } else {
                        $this->transport = 0;
                    }

                    RekapTransport::updateOrCreate(
                        [
                            'tanggal' => $absensi->tanggal,
                            'user_id' => $user->id,
                        ],
                        [
                            'tahun' => request('tahun'),
                            'bulan' => request('bulan'),
                            'hadir' => 1,
                            'transport' => $this->transport
                        ]
                    );
                }
            }

            $listUserSpesial = AturanPulangSpesial::whereUserId($user->id)
                ->whereBetween('tanggal', [request('tanggalAwal'), request('tanggalAkhir')])
                ->get();

            if (!blank($listUserSpesial)) {
                foreach ($listUserSpesial as $spesial) {
                    RekapTransport::whereTanggal($spesial->tanggal)
                        ->whereUserId($user->id)
                        ->update([
                            'transport' => 1
                        ]);
                }
            }
        }

        return to_route('proses-transport');
    }
}
