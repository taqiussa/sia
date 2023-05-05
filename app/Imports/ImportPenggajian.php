<?php

namespace App\Imports;

use App\Models\Penggajian;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportPenggajian implements ToCollection, SkipsEmptyRows, WithHeadingRow, SkipsOnFailure
{
    use SkipsErrors;
    use SkipsFailures;
    
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            Penggajian::updateOrCreate(
                [
                    'user_id' => $row['user_id'],
                    'bulan' => $row['bulan'],
                    'tahun' => $row['tahun']
                ],
                [
                    'tanggal' => date('Y-m-d'),
                    'jam' => $row['jam'],
                    'gaji_pokok' => $row['gaji_pokok'],
                    'tunjangan_jabatan' => $row['tunjangan_jabatan'],
                    'tunjangan_pendidikan' => $row['tunjangan_pendidikan'],
                    'subsidi_kuliah' => $row['subsidi_kuliah'],
                    'jumlah_hadir' => $row['jumlah_hadir'],
                    'tunjangan_transport' => $row['tunjangan_transport'],
                    'kelebihan_jam' => $row['kelebihan_jam'],
                    'tmt' => $row['tmt'],
                    'jumlah_pendapatan' => $row['jumlah_pendapatan'],
                    'wajib' => $row['wajib'],
                    'pokok' => $row['pokok'],
                    'shr' => $row['shr'],
                    'angsuran_bpd' => $row['angsuran_bpd'],
                    'angsuran_bpd_ke' => $row['angsuran_bpd_ke'],
                    'angsuran_koperasi' => $row['angsuran_koperasi'],
                    'angsuran_koperasi_ke' => $row['angsuran_koperasi_ke'],
                    'dplk' => $row['dplk'],
                    'bpjs' => $row['bpjs'],
                    'bon' => $row['bon'],
                    'iuran_wisata' => $row['iuran_wisata'],
                    'jumlah_potongan' => $row['jumlah_potongan'],
                    'jumlah_terima' => $row['jumlah_terima'],
                ]
            );
        }
    }
}
