<?php

namespace App\Imports;

use App\Models\PenilaianSikap;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportNilaiSikap implements ToCollection, WithHeadingRow, SkipsEmptyRows, SkipsOnError, SkipsOnFailure
{
    use SkipsErrors;
    use SkipsFailures;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            PenilaianSikap::updateOrCreate(
                ['id' => $row['id'] ?? null],
                [
                    'tahun' => $row['tahun'],
                    'semester' => $row['semester'],
                    'kelas_id' => $row['kelas_id'],
                    'mata_pelajaran_id' => $row['mata_pelajaran_id'],
                    'nis' => $row['nis'],
                    'kategori_sikap_id' => $row['kategori_sikap_id'],
                    'jenis_sikap_id' => $row['jenis_sikap_id'],
                    'user_id' => auth()->user()->id,
                    'nilai' => $row['nilai'] ?? null,
                    'tindak_lanjut' => $row['tindak_lanjut'] ?? ''
                ]
            );
        }
    }
}
