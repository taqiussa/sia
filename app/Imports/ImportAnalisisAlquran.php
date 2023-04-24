<?php

namespace App\Imports;

use IndikatorAlquran;
use App\Models\Penilaian;
use App\Models\AnalisisAlquran;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportAnalisisAlquran implements ToCollection, SkipsEmptyRows, WithHeadingRow
{
    use SkipsErrors;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if ($row['jenis_analisis'] == 'Proyek') {
                $nilai = $row['kebenaran'] + $row['keindahan'];
                AnalisisAlquran::updateOrCreate(
                    [
                        'tahun' => $row['tahun'],
                        'semester' => $row['semester'],
                        'kategori_nilai_id' => $row['kategori_nilai_id'],
                        'jenis_penilaian_id' => $row['jenis_penilaian_id'],
                        'kelas_id' => $row['kelas_id'],
                        'nis' => $row['nis'],
                        'indikator' => IndikatorAlquran::KEBENARAN,
                    ],
                    [
                        'user_id' => auth()->user()->id,
                        'nilai' => $row['kebenaran'],
                    ]
                );
                AnalisisAlquran::updateOrCreate(
                    [
                        'tahun' => $row['tahun'],
                        'semester' => $row['semester'],
                        'kategori_nilai_id' => $row['kategori_nilai_id'],
                        'jenis_penilaian_id' => $row['jenis_penilaian_id'],
                        'kelas_id' => $row['kelas_id'],
                        'nis' => $row['nis'],
                        'indikator' => IndikatorAlquran::KEINDAHAN,
                    ],
                    [
                        'user_id' => auth()->user()->id,
                        'nilai' => $row['keindahan'],
                    ]
                );
            } else {
                $nilai = $row['kelancaran'] + $row['makhroj'] + $row['tajwid'];
                AnalisisAlquran::updateOrCreate(
                    [
                        'tahun' => $row['tahun'],
                        'semester' => $row['semester'],
                        'kategori_nilai_id' => $row['kategori_nilai_id'],
                        'jenis_penilaian_id' => $row['jenis_penilaian_id'],
                        'kelas_id' => $row['kelas_id'],
                        'nis' => $row['nis'],
                        'indikator' => IndikatorAlquran::KELANCARAN,
                    ],
                    [
                        'user_id' => auth()->user()->id,
                        'nilai' => $row['kelancaran'],
                    ]
                );
                AnalisisAlquran::updateOrCreate(
                    [
                        'tahun' => $row['tahun'],
                        'semester' => $row['semester'],
                        'kategori_nilai_id' => $row['kategori_nilai_id'],
                        'jenis_penilaian_id' => $row['jenis_penilaian_id'],
                        'kelas_id' => $row['kelas_id'],
                        'nis' => $row['nis'],
                        'indikator' => IndikatorAlquran::MAKHROJ,
                    ],
                    [
                        'user_id' => auth()->user()->id,
                        'nilai' => $row['makhroj'],
                    ]
                );
                AnalisisAlquran::updateOrCreate(
                    [
                        'tahun' => $row['tahun'],
                        'semester' => $row['semester'],
                        'kategori_nilai_id' => $row['kategori_nilai_id'],
                        'jenis_penilaian_id' => $row['jenis_penilaian_id'],
                        'kelas_id' => $row['kelas_id'],
                        'nis' => $row['nis'],
                        'indikator' => IndikatorAlquran::TAJWID,
                    ],
                    [
                        'user_id' => auth()->user()->id,
                        'nilai' => $row['tajwid'],
                    ]
                );
            }
            Penilaian::updateOrCreate(
                [
                    'tahun' => $row['tahun'],
                    'semester' => $row['semester'],
                    'mata_pelajaran_id' => 12,
                    'kategori_nilai_id' => $row['kategori_nilai_id'],
                    'jenis_penilaian_id' => $row['jenis_penilaian_id'],
                    'kelas_id' => $row['kelas_id'],
                    'nis' => $row['nis'],
                ],
                [
                    'user_id' => auth()->user()->id,
                    'tanggal' => date('Y-m-d'),
                    'nilai' => $nilai,
                ]
            );
        }
    }
}
