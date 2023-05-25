<?php

namespace App\Http\Controllers;

use App\Models\AbsensiKaryawan;

class AbsensiKaryawanController extends Controller
{
    public function index()
    {
        return inertia(
            'Guru/AbsensiKaryawan',
            [
                'listAbsensi' => AbsensiKaryawan::whereTanggal(date('Y-m-d'))
                    ->whereUserId(auth()->user()->id)
                    ->get()
            ]
        );
    }

    public function simpan()
    {
        request()->validate(['id' => 'required']);

        $cek = AbsensiKaryawan::whereTanggal(date('Y-m-d'))
            ->whereUserId(request('id'))
            ->first();

        if (request('id') != auth()->user()->id) {
            return back()->withErrors(['message' => 'SILAHKAN PAKAI AKUN ANDA SENDIRI UNTUK ABSEN!']);
        }
        if (request('pilihan') == 'Masuk') {
            if ($cek && $cek->masuk) {
                return back()->withErrors(['message' => 'Sudah Absen Masuk!']);
            }
            AbsensiKaryawan::create([
                'user_id' => request('id'),
                'masuk' => now(),
                'tanggal' => date('Y-m-d')
            ]);
        } else {

            if (!$cek) {
                return back()->withErrors(['message' => 'Anda Belum Absen Masuk!, Silahkan Absen Masuk Terlebih Dahulu']);
            }

            if ($cek && $cek->pulang) {
                return back()->withErrors(['message' => 'Sudah Absen Pulang!']);
            }

            $cek->update([
                'pulang' => now()
            ]);
        }

        return to_route('absensi-karyawan')->with(['message' => 'Berhasil Absen ' . request('pilihan')]);
    }
}
