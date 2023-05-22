<?php

namespace App\Imports;

use App\Models\Penilaian;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportNilai implements ToCollection, WithHeadingRow, SkipsEmptyRows, SkipsOnError, SkipsOnFailure
{
    use SkipsErrors;
    use SkipsFailures;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            Penilaian::updateOrCreate(
                [
                    'id' => $row['id'] ?? null
                ],
                [
                    'tahun' => $row['tahun'],
                    'semester' => $row['semester'],
                    'mata_pelajaran_id' => $row['mata_pelajaran_id'],
                    'kategori_nilai_id' => $row['kategori_nilai_id'],
                    'jenis_penilaian_id' => $row['jenis_penilaian_id'],
                    'kelas_id' => $row['kelas_id'],
                    'nis' => $row['nis'],
                    'user_id' => auth()->user()->id,
                    'tanggal' => date('Y-m-d'),
                    'nilai' => $row['nilai'] ?? null,
                ]
            );
        }
    }
}
