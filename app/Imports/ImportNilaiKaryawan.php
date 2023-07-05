<?php

namespace App\Imports;

use App\Models\PenilaianGuru;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportNilaiKaryawan implements ToCollection, SkipsEmptyRows, WithHeadingRow
{
    use SkipsErrors;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            $row['nilai'] ?
                PenilaianGuru::updateOrCreate(
                    [
                        'tahun' => $row['tahun'],
                        'kategori_nilai_id' => $row['kategori_nilai_id'],
                        'jenis_penilaian_id' => $row['jenis_penilaian_id'],
                        'user_id' => $row['user_id'],
                        'tim_id' => auth()->user()->id,
                    ],
                    [
                        'nilai' => $row['nilai']
                    ]
                )
                :
                null;
        }
    }
}
