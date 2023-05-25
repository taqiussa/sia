<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use EnumKategoriSikap;
use App\Traits\InitTrait;
use App\Models\JenisSikap;
use App\Traits\SiswaTrait;
use App\Models\TanggalRapor;
use App\Models\AturanKurikulum;
use App\Models\Kd;
use Barryvdh\DomPDF\Facade\Pdf;

class PrintRaporController extends Controller
{
    use InitTrait;
    use SiswaTrait;

    public function index()
    {
        return inertia(
            'Guru/PrintRapor',
            [
                'initTahun' => $this->data_tahun(),
                'initSemester' => $this->data_semester(),
                'listKelas' => Kelas::orderBy('nama')->get(),
            ]
        );
    }

    public function download()
    {
        $kelas = Kelas::find(request('kelasId'));
        $tahun = request('tahun');
        $semester = request('semester');
        $nis = request('nis');
        $naik = request('naik') ?? '1';

        $cekKurikulum = AturanKurikulum::whereTahun($tahun)
            ->whereTingkat($kelas->tingkat)
            ->with(['kurikulum'])
            ->first();

        $listKd = Kd::whereTahun(request('tahun'))
            ->whereSemester(request('semester'))
            ->whereTingkat($kelas->tingkat)
            ->get();


        if ($cekKurikulum->kurikulum_id == 1) {
            $siswa = Siswa::whereNis($nis)
                ->with([
                    'absensis' => fn ($q) => $q->whereTahun($tahun)
                        ->whereSemester($semester),
                    'biodata',
                    'catatan' => fn ($q) => $q->whereTahun($tahun)
                        ->whereSemester($semester),
                    'dataAlfa' => fn ($q) => $q->whereTahun($tahun)
                        ->whereSemester($semester),
                    'penilaianEkstrakurikuler' => fn ($q) => $q->whereTahun($tahun)
                        ->whereSemester($semester),
                    'penilaianEkstrakurikuler.ekstrakurikuler',
                    'penilaianEkstrakurikuler.ekstrakurikuler.deskripsi',
                    'penilaians' => fn ($q) => $q->whereTahun($tahun)
                        ->whereSemester($semester),
                    'penilaianSikaps' => fn ($q) => $q->whereTahun($tahun)
                        ->whereSemester($semester),
                    'prestasi' => fn ($q) => $q->whereTahun($tahun)
                        ->whereSemester($semester),
                    'user'
                ])
                // ->withCount([
                //     'absensis as hitung_izin' => fn ($q) => $q->whereTahun($tahun)
                //         ->whereSemester($semester)
                //         ->whereKehadiranId(EnumKehadiran::IZIN),
                //     'absensis as hitung_sakit' => fn ($q) => $q->whereTahun($tahun)
                //         ->whereSemester($semester)
                //         ->whereKehadiranId(EnumKehadiran::SAKIT),
                // ])
                ->first();
            $data = [
                'absensis'                 => $siswa->absensis,
                'kelasId'                  => $kelas->id,
                'namaKelas'                => $kelas->nama,
                'tingkat'                  => $kelas->tingkat,
                'namaSiswa'                => $siswa->user->name,
                'nis'                      => $nis,
                'nisn'                     => $siswa->biodata->nisn,
                'tahun'                    => $tahun,
                'semester'                 => $semester,
                'listKd'                   => $listKd,
                'listSikap'                => JenisSikap::whereKategoriSikapId(EnumKategoriSikap::PANCASILA)->get(),
                'kelompok_a'               => $this->get_list_mapel($kelas->tingkat, 'A'),
                'kelompok_b'               => $this->get_list_mapel($kelas->tingkat, 'B'),
                'kelompok_c'               => $this->get_list_mapel($kelas->tingkat, 'C'),
                // 'sakit'                    => round($siswa->hitung_sakit / 4) ?? 0,
                // 'izin'                     => round($siswa->hitung_izin / 4) ?? 0,
                'alpha'                    => $siswa->dataAlfa->jumlah ?? 0,
                'naik'                     => $naik,
                'penilaians'               => $siswa->penilaians,
                'penilaianSikaps'          => $siswa->penilaianSikaps,
                'penilaianEkstrakurikuler' => $siswa->penilaianEkstrakurikuler,
                'listPrestasi'             => $siswa->prestasi,
                'catatan'                  => $siswa->catatan->catatan,
                'tanggalRapor'             => TanggalRapor::whereTahun($tahun)->whereSemester($semester)->first(),
                'namaWaliKelas'            => $this->data_nama_wali_kelas(),
                'namaKepalaSekolah'        => $this->data_nama_kepala_sekolah(),
            ];

            $pdf = Pdf::loadView('download.rapor-kurtilas', $data)->setPaper(array(0, 0, 609.449, 921.26))->download();

            return response()->streamDownload(
                fn () => print($pdf),
                $siswa->user->name . '.pdf'
            );
        } else {

            $siswa = Siswa::whereNis($nis)
                ->with([
                    'absensis' => fn ($q) => $q->whereTahun($tahun)
                        ->whereSemester($semester),
                    'biodata',
                    'catatan' => fn ($q) => $q->whereTahun($tahun)
                        ->whereSemester($semester),
                    'dataAlfa' => fn ($q) => $q->whereTahun($tahun)
                        ->whereSemester($semester),
                    'penilaianEkstrakurikuler' => fn ($q) => $q->whereTahun($tahun)
                        ->whereSemester($semester),
                    'penilaianEkstrakurikuler.ekstrakurikuler',
                    'penilaianEkstrakurikuler.ekstrakurikuler.deskripsi',
                    'penilaians' => fn ($q) => $q->whereTahun($tahun)
                        ->whereSemester($semester),
                    'user'
                ])
                // ->withCount([
                //     'absensis as hitung_izin' => fn ($q) => $q->whereTahun($tahun)
                //         ->whereSemester($semester)
                //         ->whereKehadiranId(EnumKehadiran::IZIN),
                //     'absensis as hitung_sakit' => fn ($q) => $q->whereTahun($tahun)
                //         ->whereSemester($semester)
                //         ->whereKehadiranId(EnumKehadiran::SAKIT),
                // ])
                ->first();

            $data = [
                'absensis'                 => $siswa->absensis,
                'kelasId'                  => $kelas->id,
                'namaKelas'                => $kelas->nama,
                'tingkat'                  => $kelas->tingkat,
                'namaSiswa'                => $siswa->user->name,
                'nis'                      => $nis,
                'nisn'                     => $siswa->biodata->nisn,
                'tahun'                    => $tahun,
                'semester'                 => $semester,
                'listKd'                   => $listKd,
                'kelompok_a'               => $this->get_list_mapel($kelas->tingkat, 'A'),
                'kelompok_b'               => $this->get_list_mapel($kelas->tingkat, 'B'),
                'kelompok_c'               => $this->get_list_mapel($kelas->tingkat, 'C'),
                // 'sakit'                    => round($siswa->hitung_sakit / 4) ?? 0,
                // 'izin'                     => round($siswa->hitung_izin / 4) ?? 0,
                'alpha'                    => $siswa->dataAlfa->jumlah ?? 0,
                'naik'                     => $naik,
                'penilaians'               => $siswa->penilaians,
                'penilaianEkstrakurikuler' => $siswa->penilaianEkstrakurikuler,
                'catatan'                  => $siswa->catatan->catatan,
                'tanggalRapor'             => TanggalRapor::whereTahun($tahun)->whereSemester($semester)->first(),
                'namaWaliKelas'            => $this->data_nama_wali_kelas(),
                'namaKepalaSekolah'        => $this->data_nama_kepala_sekolah(),
            ];

            $pdf = Pdf::loadView('download.rapor-merdeka', $data)->setPaper(array(0, 0, 609.449, 921.26))->download();

            return response()->streamDownload(
                fn () => print($pdf),
                $siswa->user->name . '.pdf'
            );
        }
    }
}
