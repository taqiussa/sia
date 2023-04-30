<?php

namespace App\Http\Controllers;

use App\Models\JenisPenilaian;
use App\Models\KategoriNilai;
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
                'listKelas' => $this->data_kelas(),
                'listMapel' => $this->data_mapel(),
                'listKategori' => KategoriNilai::whereIn('id', $this->data_kategori_nilai())->orderBy('nama')->get(),
                'listJenis' => JenisPenilaian::whereIn('id', $this->data_jenis_penilaian())
                    ->whereKategoriNilaiId(request('kategoriNilaiId'))
                    ->orderBy('nama')
                    ->get()
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

        return to_route('input-nilai-remidi', [
            'tahun' => request('tahun'),
            'semester' => request('semester'),
            'tanggal' => request('tanggal'),
            'kelasId' => request('kelasId'),
            'mataPelajaranId' => request('mataPelajaranId'),
            'kategoriNilaiId' => request('kategoriNilaiId'),
            'jenisPenilaianId' => request('jenisPenilaianId'),
        ]);
    }

    public function update()
    {
        $remidi = Remidi::updateOrCreate(
            ['id' => request('remidiId')],
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

        RemidiDetail::updateOrCreate(
            ['id' => request('id')],
            [
                'remidi_id' => $remidi->id,
                'tahun' => request('tahun'),
                'semester' => request('semester'),
                'tanggal' => request('tanggal'),
                'kelas_id' => request('kelasId'),
                'mata_pelajaran_id' => request('mataPelajaranId'),
                'kategori_nilai_id' => request('kategoriNilaiId'),
                'jenis_penilaian_id' => request('jenisPenilaianId'),
                'nis' => request('nis'),
                'nilai_awal' => request('nilaiAwal'),
                'nilai_akhir' => $kkm,
                'nilai_remidi' => request('nilaiRemidi'),
            ]
        );

        Penilaian::find(request('penilaianId'))
            ->update([
                'nilai' => $kkm
            ]);

        return response()->json([
            'listSiswa' => $this->data_siswa_with_nilai_remidi(),
            'message' => 'Tersimpan',
            'nis' => request('nis')
        ]);
    }
}
