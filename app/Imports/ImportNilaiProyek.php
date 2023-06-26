<?php

namespace App\Imports;

use App\Models\PenilaianProyek;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportNilaiProyek implements ToCollection, WithHeadingRow, SkipsEmptyRows, SkipsOnError, SkipsOnFailure
{
    use SkipsErrors, SkipsFailures;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            PenilaianProyek::updateOrCreate(
                [
                    'tahun' => $row['tahun'],
                    'kelas_id' => $row['kelas_id'],
                    'proyek_id' => $row['proyek_id'],
                    'dimensi_id' => $row['dimensi_id'],
                    'nis' => $row['nis'],
                ],
                [
                    'nilai' => $row['nilai'] ?? null,
                ]
            );
        }
    }
}
