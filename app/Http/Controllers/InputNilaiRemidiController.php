<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Kkm;
use App\Models\Penilaian;
use App\Models\Remidi;
use App\Models\RemidiDetail;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class InputNilaiRemidiController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/InputNilaiRemidi',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listMapel' => $this->data_mapel(),
            ]
        );
    }

    public function simpan()
    {
        request()->validate([
            'tahun' => 'required',
            'tanggal' => 'required',
            'semester' => 'required',
            'mataPelajaranId' => 'required',
            'kelasId' => 'required',
            'kategoriNilaiId' => 'required',
            'jenisPenilaianId' => 'required',
            'nilaiRemidi' => 'numeric|max:100'
        ]);

        Remidi::updateOrCreate(
            ['id' => request('id')],
            [
                'tahun' => request('tahun'),
                'semester' => request('semester'),
                'tanggal' => request('tanggal'),
                'kelas_id' => request('kelasId'),
                'mata_pelajaran_id' => request('mataPelajaranId'),
                'kategori_nilai_id' => request('kategoriNilaiId'),
                'jenis_penilaian_id' => request('jenisPenilaianId'),
                'ki' => request('ki'),
                'materi' => request('materi'),
                'catatan' => request('catatan'),
            ]
        );

        $kelas = Kelas::find(request('kelasId'));

        $kkm = Kkm::whereTahun(request('tahun'))
            ->whereMataPelajaranId(request('mataPelajaranId'))
            ->whereTingkat($kelas->tingkat)
            ->value('kkm');

        $listSiswa = request('arrayInput');

        foreach ($listSiswa as $siswa) {
            if ($siswa['remidi'] != null) {

                RemidiDetail::updateOrCreate(
                    ['id' => $siswa['remidi']['id'] ?? null],
                    [
                        'remidi_id' => $siswa['remidi']['remidi_id'],
                        'tahun' => request('tahun'),
                        'semester' => request('semester'),
                        'tanggal' => request('tanggal'),
                        'kelas_id' => request('kelasId'),
                        'mata_pelajaran_id' => request('mataPelajaranId'),
                        'kategori_nilai_id' => request('kategoriNilaiId'),
                        'jenis_penilaian_id' => request('jenisPenilaianId'),
                        'nis' => $siswa['nis'],
                        'nilai_awal' => $siswa['remidi']['nilai_awal'],
                        'nilai_akhir' => $kkm,
                        'nilai_remidi' => $siswa['remidi']['nilai_remidi'] ?? null,
                    ]
                );

                Penilaian::whereTahun(request('tahun'))
                    ->whereSemester(request('semester'))
                    ->whereMataPelajaranId(request('mataPelajaranId'))
                    ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->whereJenisPenilaianId(request('jenisPenilaianId'))
                    ->whereKelasId(request('kelasId'))
                    ->whereNis($siswa['nis'])
                    ->update([
                        'nilai' => $kkm
                    ]);
            }
        }

        return to_route('input-nilai-remidi');
    }

    public function hapus()
    {
        Penilaian::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->whereMataPelajaranId(request('mataPelajaranId'))
            ->whereKategoriNilaiId(request('kategoriNilaiId'))
            ->whereJenisPenilaianId(request('jenisPenilaianId'))
            ->whereKelasId(request('kelasId'))
            ->whereNis(request('nis'))
            ->update([
                'nilai' =>  request('nilaiAwal')
            ]);


        RemidiDetail::destroy(request('remidiId'));

        return to_route('input-nilai-remidi');
    }
}
