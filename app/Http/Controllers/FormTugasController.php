<?php

namespace App\Http\Controllers;

use App\Models\Badalan;
use App\Traits\InitTrait;

class FormTugasController extends Controller
{
    use InitTrait;

    public function index()
    {
        return inertia(
            'Guru/FormTugas',
            [
                'initTahun' => $this->data_tahun(),
                'listMapel' => $this->data_mapel(),
                'listKelas' => $this->data_kelas(),
                'listTugas' => Badalan::whereTanggal(request('tanggal'))
                    ->whereUserId(auth()->user()->id)
                    ->with([
                        'badal' => fn ($q) => $q->select('id', 'name'),
                        'kelas' => fn ($q) => $q->select('id', 'nama'),
                        'mapel' => fn ($q) => $q->select('id', 'nama'),
                    ])
                    ->orderBy('jam')
                    ->get()
            ]
        );
    }

    public function hapus()
    {
        Badalan::destroy(request('id'));

        return to_route('form-tugas', [
            'tahun' => request('tahun'),
            'tanggal' => request('tanggal'),
            'kelasId' => request('kelasId'),
            'mataPelajaranId' => request('mataPelajaranId'),
            'jam' => request('jam'),
            'tugas' => request('tugas')
        ]);
    }

    public function simpan()
    {
        request()->validate([
            'tanggal' => 'required',
            'mataPelajaranId' => 'required',
            'jam' => 'required',
            'kelasId' => 'required',
            'tugas' => 'required'
        ]);

        $cekGuruJam = Badalan::whereTanggal(request('tanggal'))
            ->whereUserId(auth()->user()->id)
            ->whereJam(request('jam'))
            ->count();

        $cekKelasJam = Badalan::whereTanggal(request('tanggal'))
            ->whereKelasId(request('kelasId'))
            ->whereJam(request('jam'))
            ->count();

        $cekGuruKelas = Badalan::whereTanggal(request('tanggal'))
            ->whereKelasId(request('kelasId'))
            ->whereUserId(auth()->user()->id)
            ->count();

        if ($cekGuruJam > 0) {
            return back()->withErrors(['pesan' => 'Anda Sudah Membuat Form Tugas di Jam ini']);
        } elseif ($cekKelasJam > 0) {
            return back()->withErrors(['pesan' => 'Kelas Ini Sudah terisi Form Tugas']);
        } elseif ($cekGuruKelas > 0) {
            return back()->withErrors(['pesan' => 'Anda Sudah Membuat Form Tugas di Kelas ini']);
        } else {
            Badalan::create(
                [
                    'tahun' => $this->data_tahun(),
                    'semester' => $this->data_semester(),
                    'tanggal' => request('tanggal'),
                    'user_id' => auth()->user()->id,
                    'kelas_id' => request('kelasId'),
                    'mata_pelajaran_id' => request('mataPelajaranId'),
                    'jam' => request('jam'),
                    'tugas' => request('tugas')
                ]
            );

            return to_route(
                'form-tugas',
                [
                    'tahun' => request('tahun'),
                    'tanggal' => request('tanggal'),
                    'kelasId' => request('kelasId'),
                    'mataPelajaranId' => request('mataPelajaranId'),
                    'jam' => request('jam'),
                    'tugas' => request('tugas')
                ]
            );
        }
    }
}
