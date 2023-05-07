<?php

namespace App\Http\Controllers;

use EnumKehadiran;
use App\Models\Kelas;
use App\Models\Siswa;
use EnumKategoriSikap;
use App\Traits\InitTrait;
use App\Models\JenisSikap;
use App\Traits\SiswaTrait;
use App\Models\TanggalRapor;
use App\Models\KurikulumMapel;
use App\Models\AturanKurikulum;
use Barryvdh\DomPDF\Facade\Pdf;

class PrintRaporControllerBackup extends Controller
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

        $siswa = Siswa::whereNis($nis)
            ->with([
                'biodata',
                'catatan' => fn ($q) => $q->whereTahun($tahun)
                    ->whereSemester($semester),
                'dataAlfa' => fn ($q) => $q->whereTahun($tahun)
                    ->whereSemester($semester),
                'penilaianEkstrakurikuler' => fn ($q) => $q->whereTahun($tahun)
                    ->whereSemester($semester),
                'penilaianEkstrakurikuler.ekstrakurikuler',
                'penilaianEkstrakurikuler.ekstrakurikuler.deskripsi',
                'prestasi' => fn ($q) => $q->whereTahun($tahun)
                    ->whereSemester($semester),
            ])
            ->withCount([
                'absensis as hitung_izin' => fn ($q) => $q->whereTahun($tahun)
                    ->whereSemester($semester)
                    ->whereKehadiranId(EnumKehadiran::IZIN),
                'absensis as hitung_sakit' => fn ($q) => $q->whereTahun($tahun)
                    ->whereSemester($semester)
                    ->whereKehadiranId(EnumKehadiran::SAKIT),
            ])
            ->first();

        if ($cekKurikulum->kurikulum->nama == 'K13') {
            $data = [
                'kelasId' => $kelas->id,
                'namaKelas' => $kelas->nama,
                'tingkat' => $kelas->tingkat,
                'namaSiswa' => $siswa->user->name,
                'nis' => $nis,
                'nisn' => $siswa->biodata->nisn,
                'tahun' => $tahun,
                'semester' => $semester,
                'listSikap' => JenisSikap::whereKategoriSikapId(EnumKategoriSikap::PANCASILA)
                    ->get(),
                'kelompok_a' => $this->get_nilai_kurtilas($nis, $kelas->tingkat, 'A'),
                'kelompok_b' => $this->get_nilai_kurtilas($nis, $kelas->tingkat, 'B'),
                'kelompok_c' => $this->get_nilai_kurtilas($nis, $kelas->tingkat, 'C'),
                'sakit' => round($siswa->hitung_sakit / 4) ?? 0,
                'izin' => round($siswa->hitung_izin / 4) ?? 0,
                'alpha' => $siswa->dataAlfa->jumlah ?? 0,
                'naik' => $naik,
                'penilaianEkstrakurikuler' => $siswa->penilaianEkstrakurikuler,
                'listPrestasi' => $siswa->prestasi,
                'catatan' => $siswa->catatan->catatan,
                'tanggalRapor' => TanggalRapor::whereTahun($tahun)
                    ->whereSemester($semester)
                    ->first(),
                'namaWaliKelas' => $this->data_nama_wali_kelas(),
                'namaKepalaSekolah' => $this->data_nama_kepala_sekolah(),
            ];

            $pdf = Pdf::loadView('download.rapor-kurtilas', $data)->setPaper(array(0, 0, 609.449, 921.26))->download();

            return response()->streamDownload(
                fn () => print($pdf),
                $siswa->user->name . '.pdf'
            );
        }
    }

    private function get_nilai_kurtilas($nis, $tingkat, $kelompok)
    {
        return KurikulumMapel::whereTahun(request('tahun'))
            ->whereTingkat($tingkat)
            ->with([
                'mapel',
                'kkm' => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereTingkat($tingkat),
                'kd' => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereTingkat($tingkat),
                'penilaian' => fn ($q) => $q->whereTahun(request('tahun'))
                    ->whereSemester(request('semester'))
                    ->whereNis($nis),
            ])
            ->whereHas('mapel', fn ($q) => $q->whereKelompok($kelompok))
            ->get();
    }
}
