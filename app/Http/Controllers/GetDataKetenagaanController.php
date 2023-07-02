<?php

namespace App\Http\Controllers;

use App\Models\AbsensiKaryawan;
use App\Models\AturanKhususPulang;
use App\Models\AturanPulangSpesial;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Badalan;
use App\Models\JamKosong;
use App\Models\RekapTransport;
use App\Traits\InitTrait;

class GetDataKetenagaanController extends Controller
{
    use InitTrait;

    public function get_aturan_khusus_pulang()
    {
        return response()->json([
            'listAturan' => AturanKhususPulang::whereTahun(request('tahun'))
                ->with('user')
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }

    public function get_list_aturan_pulang_spesial()
    {
        return response()->json([
            'listSpesial' => AturanPulangSpesial::whereTahun(request('tahun'))
                ->with('user')
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }

    public function get_permintaan_badal()
    {
        return response()->json([
            'listPermintaan' => Badalan::whereTanggal(request('tanggal'))
                ->whereNull('badal_id')
                ->with([
                    'badal' => fn ($q) => $q->select('id', 'name'),
                    'kelas' => fn ($q) => $q->select('id', 'nama'),
                    'mapel' => fn ($q) => $q->select('id', 'nama'),
                    'user' => fn ($q) => $q->select('id', 'name'),
                ])
                ->orderBy('jam')
                ->get()
        ]);
    }

    public function get_guru_izin()
    {
        return response()->json([
            'listGuruIzin' => Badalan::whereTanggal(request('tanggal'))
                ->pluck('user_id')
        ]);
    }

    public function get_guru_kosong()
    {
        $hari = Carbon::parse(request('tanggal'))
            ->dayOfWeek;

        return response()->json([
            'listGuruKosong' => User::withCount([
                'jamKosong' => fn ($q) => $q->whereHari($hari)
                    ->whereTahun($this->data_tahun())
                    ->whereSemester($this->data_semester())
            ])
                ->withWhereHas('jamKosong', fn ($q) => $q->whereHari($hari)
                    ->whereTahun($this->data_tahun())
                    ->whereSemester($this->data_semester()))
                ->orderBy('name')
                ->get()
        ]);
    }

    public function get_guru_sudah_badal()
    {
        return response()->json([
            'listGuruSudahBadal' => Badalan::whereTanggal(request('tanggal'))
                ->where('badal_id', '!=', null)
                ->get()
        ]);
    }

    public function get_list_jadwal_kosong()
    {
        return response()->json([
            'listJadwal' => JamKosong::whereUserId(request('userId'))
                ->whereTahun(request('tahun'))
                ->orderBy('semester')
                ->orderBy('hari')
                ->orderBy('jam')
                ->get()
        ]);
    }

    public function get_rekap_jam_kosong()
    {
        return response()->json([
            'listJamKosong' => JamKosong::whereTahun(request('tahun'))
                ->whereSemester(request('semester'))
                ->whereHari(request('hari'))
                ->whereJam(request('jam'))
                ->with([
                    'user' => fn ($q) => $q->select('id', 'name')
                ])
                ->get()
                ->sortBy('user.name')
                ->values()
        ]);
    }

    public function get_rekap_transport()
    {
        return response()->json([
            'listAbsensi' => AbsensiKaryawan::whereUserId(auth()->user()->id)
                ->get(),
            'listTransport' => RekapTransport::whereBulan(request('bulan'))
                ->whereUserId(auth()->user()->id)
                ->whereTahun(request('tahun'))
                ->get()
        ]);
    }
}
