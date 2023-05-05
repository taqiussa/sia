<?php

namespace App\Imports;

use App\Models\Penilaian;
use App\Models\AnalisisPenilaian;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportAnalisisNilai implements ToCollection, SkipsEmptyRows, WithHeadingRow
{
    use SkipsErrors;
    use SkipsFailures;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            if ($row['kategori_nilai_id'] == 3 || $row['kategori_nilai_id'] == 6) {
                if ($row['skor_maks']) {
                    $total = $row['no_1'] + $row['no_2'] + $row['no_3'] + $row['no_4'] + $row['no_5'] + $row['no_6'] + $row['no_7'] + $row['no_8'] + $row['no_9'] + $row['no_10'];
                    $nilai = ($total / $row['skor_maks']) * 100;
                } else {
                    $nilai = $row['no_1'] + $row['no_2'] + $row['no_3'] + $row['no_4'] + $row['no_5'] + $row['no_6'] + $row['no_7'] + $row['no_8'] + $row['no_9'] + $row['no_10'];
                }
                AnalisisPenilaian::updateOrCreate(
                    [
                        'tahun' => $row['tahun'],
                        'semester' => $row['semester'],
                        'mata_pelajaran_id' => $row['mata_pelajaran_id'],
                        'kategori_nilai_id' => $row['kategori_nilai_id'],
                        'jenis_penilaian_id' => $row['jenis_penilaian_id'],
                        'kelas_id' => $row['kelas_id'],
                        'nis' => $row['nis'],
                    ],
                    [
                        'user_id' => auth()->user()->id,
                        'tanggal' => date('Y-m-d'),
                        'no_1' => $row['no_1'],
                        'no_2' => $row['no_2'],
                        'no_3' => $row['no_3'],
                        'no_4' => $row['no_4'],
                        'no_5' => $row['no_5'],
                        'no_6' => $row['no_6'],
                        'no_7' => $row['no_7'],
                        'no_8' => $row['no_8'],
                        'no_9' => $row['no_9'],
                        'no_10' => $row['no_10'],
                        'nilai' => $nilai,
                    ]
                );
            } else {
                if ($row['skor_maks']) {
                    $total = $row['aspek_1'] + $row['aspek_2'] + $row['aspek_3'] + $row['aspek_4'];
                    $nilai = ($total / $row['skor_maks']) * 100;
                } else {
                    $nilai = $row['aspek_1'] + $row['aspek_2'] + $row['aspek_3'] + $row['aspek_4'];
                }
                AnalisisPenilaian::updateOrCreate(
                    [
                        'tahun' => $row['tahun'],
                        'semester' => $row['semester'],
                        'mata_pelajaran_id' => $row['mata_pelajaran_id'],
                        'kategori_nilai_id' => $row['kategori_nilai_id'],
                        'jenis_penilaian_id' => $row['jenis_penilaian_id'],
                        'kelas_id' => $row['kelas_id'],
                        'nis' => $row['nis'],
                    ],
                    [
                        'user_id' => auth()->user()->id,
                        'tanggal' => date('Y-m-d'),
                        'no_1' => $row['aspek_1'],
                        'no_2' => $row['aspek_2'],
                        'no_3' => $row['aspek_3'],
                        'no_4' => $row['aspek_4'],
                        'nilai' => $nilai,
                    ]
                );
            }

            Penilaian::updateOrCreate(
                [
                    'tahun' => $row['tahun'],
                    'semester' => $row['semester'],
                    'mata_pelajaran_id' => $row['mata_pelajaran_id'],
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
