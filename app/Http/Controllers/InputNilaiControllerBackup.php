<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Traits\InitTrait;
use App\Traits\SiswaTrait;

class InputNilaiControllerBackup extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/InputNilai',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listMapel' => $this->data_mapel(),
            ]
        );
    }

    public function simpan()
    {
        request()->validate(['jenisPenilaianId' => 'required'], ['jenisPenilaianId.required' => 'Pilih Jenis Penilaian']);

        Penilaian::updateOrCreate(
            ['id' => request('id')],
            [
                'tanggal' => date('Y-m-d'),
                'nis' => request('nis'),
                'tahun' => request('tahun'),
                'semester' => request('semester'),
                'kelas_id' => request('kelasId'),
                'mata_pelajaran_id' => request('mataPelajaranId'),
                'kategori_nilai_id' => request('kategoriNilaiId'),
                'jenis_penilaian_id' => request('jenisPenilaianId'),
                'nilai' => request('nilai'),
                'user_id' => auth()->user()->id
            ]
        );

        return response()->json([
            'listSiswa' => $this->data_siswa_with_nilai(),
            'message' => 'Tersimpan',
            'nis' => request('nis')
        ]);
    }

    public function hapus()
    {
        Penilaian::destroy(request('id'));

        return to_route('input-nilai');
    }
}
