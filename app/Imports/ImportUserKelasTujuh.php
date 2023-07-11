<?php

namespace App\Imports;

use App\Models\Alamat;
use App\Models\Biodata;
use App\Models\OrangTua;
use App\Models\SekolahSd;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Wali;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportUserKelasTujuh implements ToCollection, WithHeadingRow, SkipsEmptyRows, SkipsOnError, SkipsOnFailure
{
    use SkipsErrors;
    use SkipsFailures;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {

            User::create(
                [
                    'name' => $row['nama'],
                    'jenis_kelamin' => $row['jenis_kelamin'],
                    'nis' => $row['nis'],
                    'password' => bcrypt('12345678'),
                    'is_active' => 1
                ]
            );

            Alamat::create(
                [
                    'nis' => $row['nis'],
                    'alamat' => $row['alamat'],
                    'rt' => $row['rt'],
                    'rw' => $row['rw'],
                    'desa' => $row['desa'],
                    'kecamatan' => $row['kecamatan'],
                    'kabupaten' => $row['kabupaten'],
                    'provinsi' => $row['provinsi'],
                ]
            );

            Biodata::create([
                'nis' => $row['nis'],
                'nisn' => $row['nisn'],
                'nik' => $row['nik'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'tempat_lahir' => $row['tempat_lahir'],
                'tanggal_lahir' => $row['tanggal_lahir'],
                'telepon' => $row['telepon'],
                'no_kps' => $row['no_kps'],
                'no_kip' => $row['no_kip'],
                'status' => $row['status'],
                'anak_ke' => $row['anak_ke'],
                'agama' => 'ISLAM',
                'tanggal_terima' => $row['tanggal_terima'],
                'pindahan' => 0,
                'kelas' => 7
            ]);

            OrangTua::create([
                'nis' => $row['nis'],
                'nama_ayah' => $row['nama_ayah'],
                'nama_ibu' => $row['nama_ibu'],
                'pekerjaan_ayah' => $row['pekerjaan_ayah'],
                'pekerjaan_ibu' => $row['pekerjaan_ibu'],
                'penghasilan_ayah' => $row['penghasilan'],
            ]);

            SekolahSd::create([
                'nis' => $row['nis'],
                'nama_sekolah' => $row['nama_sd'],
                'desa' => $row['desa_sd'],
                'kecamatan' => $row['kecamatan_sd'],
                'kabupaten' => $row['kabupaten_sd'],
                'provinsi' => $row['provinsi_sd'],
            ]);

            $row['nama_wali'] ?
                Wali::create([
                    'nis' => $row['nis'],
                    'nama_wali' => $row['nama_wali'],
                    'telepon' => $row['telepon_wali'],
                    'pekerjaan' => $row['pekerjaan_wali'],
                    'penghasilan' => $row['penghasilan_wali'],
                    'alamat' => $row['alamat_wali'],
                ])
                :
                null;

            Siswa::create([
                'nis' => $row['nis'],
                'tahun' => $row['tahun'],
                'kelas_id' => $row['kelas_id'],
                'tingkat' => 7
            ]);
        }
    }
}
