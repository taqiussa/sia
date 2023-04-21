<?php

// namespace App\Helpers;

use Carbon\Carbon;

function rupiah($angka)
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function ambilAngka($string)
{
    return  str_replace(['Rp. ', '.'], '', $string);
}

function tanggal($tanggal)
{
    return Carbon::parse($tanggal)->translatedFormat('d F Y');
}

function tanggalSingkat($tanggal)
{
    return Carbon::parse($tanggal)->translatedFormat('d M Y');
}

function hariTanggal($tanggal)
{
    return Carbon::parse($tanggal)->translatedFormat('l, d F Y');
}

function namaHari($hari)
{
    $nama_hari = '';

    switch ($hari) {
        case '1':
            $nama_hari = 'Senin';
            break;
        case '2':
            $nama_hari = 'Selasa';
            break;
        case '3':
            $nama_hari = 'Rabu';
            break;
        case '4':
            $nama_hari = 'Kamis';
            break;
        case '5':
            $nama_hari = 'Jumat';
            break;
        case '6':
            $nama_hari = 'Sabtu';
            break;

        default:
            # code...
            break;
    }

    return $nama_hari;
}
function namaBulan($bulan)
{
    return Carbon::parse(date('Y-' . $bulan . '-d'))->translatedFormat('F');
}

function arrayBulan()
{
    return json_decode(json_encode([
        [
            'id' => '01',
            'nama' => 'Januari'
        ],
        [
            'id' => '02',
            'nama' => 'Februari'
        ],
        [
            'id' => '03',
            'nama' => 'Maret'
        ],
        [
            'id' => '04',
            'nama' => 'April'
        ],
        [
            'id' => '05',
            'nama' => 'Mei'
        ],
        [
            'id' => '06',
            'nama' => 'Juni'
        ],
        [
            'id' => '07',
            'nama' => 'Juli'
        ],
        [
            'id' => '08',
            'nama' => 'Agustus'
        ],
        [
            'id' => '09',
            'nama' => 'September'
        ],
        [
            'id' => '10',
            'nama' => 'Oktober'
        ],
        [
            'id' => '11',
            'nama' => 'November'
        ],
        [
            'id' => '12',
            'nama' => 'Desember'
        ],

    ]), false);
}

function arrayJenisIbadah()
{
    return json_decode(json_encode(
        [
            [
                'id' => 1,
                'nama' => 'Dhuha'
            ],
            [
                'id' => 2,
                'nama' => 'Dhuhur'
            ],
            [
                'id' => 3,
                'nama' => 'Tadarus'
            ]
        ]
    ), false);
}

function arrayKategoriPenilaianGuru()
{
    return json_decode(json_encode(
        [
            [
                'id' => 1,
                'nama' => 'Guru'
            ],
            [
                'id' => 2,
                'nama' => 'Karyawan'
            ]
        ]
    ), false);
}

function arrayKehadiranIbadah()
{
    return json_decode(json_encode(
        [
            [
                'id' => 1,
                'nama' => 'Hadir'
            ],
            [
                'id' => 2,
                'nama' => 'Izin'
            ],
            [
                'id' => 3,
                'nama' => 'Alpha'
            ],
        ]
    ), false);
}

enum IndikatorAlquran: int
{
    case KEBENARAN = 1;
    case KEINDAHAN = 2;
    case KELANCARAN = 3;
    case MAKHROJ = 4;
    case TAJWID = 5;
}

enum EnumKategoriAlquran: int
{
    case BILGHOIB = 1;
    case BINNADZOR = 2;
}

enum EnumKategoriPenilaian: int
{
    case PENGETAHUAN = 3;
    case KETERAMPILAN = 4;
    case FORMATIF = 5;
    case SUMATIF = 6;
}

enum EnumKehadiran: int
{
    case HADIR = 1;
    case SAKIT = 2;
    case IZIN = 3;
    case ALPHA = 4;
    case BOLOS = 5;
    case IZIN_PULANG = 6;
}

enum EnumKategoriSikap: int
{
    case SPIRITUAL = 1;
    case SOSIAL = 2;
    case PANCASILA = 3;
}

enum EnumBulan: int
{
    case JULI = 1;
    case AGUSTUS = 2;
    case SEPTEMBER = 3;
    case OKTOBER = 4;
    case NOVEMBER = 5;
    case DESEMBER = 6;
    case JANUARI = 7;
    case FEBRUARI = 8;
    case MARET = 9;
    case APRIL = 10;
    case MEI = 11;
    case JUNI = 12;
}

enum EnumStatusSiswa: int
{
    case PINDAH = 1;
    case LULUS = 2;
}

enum EnumKategoriGuru: int
{
    case Guru = 1;
    case Karyawan = 2;
    case WaliKelas = 3;
}

enum EnumJenisIbadah: int
{
    case Dhuha = 1;
    case Dhuhur = 2;
    case Tadarus = 3;
}

enum EnumKehadiranIbadah: int
{
    case Hadir = 1;
    case Izin = 2;
    case Alpha = 3;
}
