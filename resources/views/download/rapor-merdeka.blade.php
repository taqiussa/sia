<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rapor Kurikulum Merdeka</title>
    <style type="text/css">
        body {
            font-family: 'Times New Roman', Times, serif !important;
            font-size: 12pt;
            margin-top: 1cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 2cm;
        }

        @page {
            margin: 0cm 0cm;
        }

        footer {
            position: fixed;
            bottom: 1cm;
            left: 1cm;
            right: 0cm;
            font-size: 11pt !important;
        }

        .bg-slate {
            background-color: #d1d5db;
        }

        .table {
            border-collapse: collapse;
            border: solid 1px #000;
            width: 100%
        }

        .table tr td,
        .table tr th {
            border: solid 1px #000;
            padding: 3px;
        }

        .table tr th {
            font-weight: bold;
            text-align: center
        }

        .rgt {
            text-align: right;
        }

        .ctr {
            text-align: center;
        }

        .tbl {
            font-weight: bold
        }

        table tr td {
            vertical-align: top
        }

        .font_kecil {
            font-size: 12px
        }

        div.footer {
            position: fixed;
            bottom: 0px;
        }

        @media screen {
            div.footer {
                display: none;
            }

        }

        @media print {
            div.footer {
                position: fixed;
                bottom: 0px;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }


        }
    </style>
</head>

<body>
    <footer>
        {{ $namaSiswa }} | {{ $nis }} | Kelas : {{ $namaKelas }} | {{ $tahun }}
    </footer>
    <table style="text-align:justify; border-collapse:collapse;" width="100%">
        <tbody>
            <tr>
                <td width="15%">Nama Sekolah</td>
                <td width="1%">:</td>
                <td width="45%" style="white-space: nowrap">SMP Al Musyaffa</td>
                <td width="8%">&nbsp;</td>
                <td width="15%">Kelas</td>
                <td width="1%">:</td>
                <td width="15%">{{ $namaKelas }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td style="white-space: nowrap">Jl. Kampir Sudipayung, Kec. Ngampel, Kab. Kendal</td>
                <td>&nbsp;</td>

                <td>Semester</td>
                <td>:</td>
                <td>{{ $semester }}</td>
            </tr>
            <tr>
                <td>Nama Siswa</td>
                <td>:</td>
                <td style="white-space: nowrap">{{ $namaSiswa }}</td>
                <td>&nbsp;</td>

                <td>Tahun</td>
                <td>:</td>
                <td style="white-space: nowrap">{{ $tahun }}</td>
            </tr>
            <tr>
                <td>NIS / NISN</td>
                <td>:</td>
                <td>{{ $nis }} / {{ $nisn }}</td>
                <td colspan="4"></td>
            </tr>
        </tbody>
    </table>
    <hr>
    <div style="text-align: center">
        <h4>LAPORAN HASIL BELAJAR</h4>
    </div>
    <div style="padding:5px;"></div>
    <table class="table">
        <thead>
            <tr class="bg-slate" style="border: #000 1px solid">
                <th width="5%">No</th>
                <th width="25%">Mata Pelajaran</th>
                <th width="8%">Nilai Akhir</th>
                <th width="46%">Capaian Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kelompok_a as $mapela)
                <tr style="page-break-inside: avoid; height: 150px;">
                    <td style="text-align: center; vertical-align:middle;">{{ $loop->iteration }}</td>
                    <td style="text-align: left; vertical-align:middle;padding-left: 10px;">{{ $mapela->mapel->nama }}
                    </td>
                    <td style="text-align: center; vertical-align:middle;">
                        {{ floor($penilaians->where('kategori_nilai_id', 6)->where('mata_pelajaran_id', $mapela->mata_pelajaran_id)->avg('nilai')) }}
                    </td>
                    <td style="text-align: justify; padding:10px;vertical-align:middle;">
                        @foreach ($penilaians->where('mata_pelajaran_id', $mapela->mata_pelajaran_id) as $nilai)
                            @php
                                if ($nilai->nilai < 60) {
                                    $predikat_a = 'Perlu penguatan';
                                } elseif ($nilai->nilai < 70) {
                                    $predikat_a = 'Menunjukkan penguasaan yang cukup';
                                } elseif ($nilai->nilai < 80) {
                                    $predikat_a = 'Menunjukkan penguasaan yang baik';
                                } else {
                                    $predikat_a = 'Menunjukkan penguasaan yang sangat baik';
                                }
                            @endphp
                            @foreach ($listKd->where('mata_pelajaran_id', $mapela->mata_pelajaran_id) as $kd)
                                @if ($kd->jenis_penilaian_id === $nilai->jenis_penilaian_id)
                                    {{ $predikat_a . ' dalam ' . $kd->deskripsi . '.' }}
                                @endif
                            @endforeach
                        @endforeach
                    </td>
                </tr>
            @endforeach
            @foreach ($kelompok_b as $mapelb)
                <tr style="page-break-inside: avoid; height: 150px;">
                    <td style="text-align: center; vertical-align:middle;">{{ $loop->iteration + 7 }}</td>
                    <td style="text-align: left; vertical-align:middle;padding-left: 10px;">{{ $mapelb->mapel->nama }}
                    </td>
                    <td style="text-align: center; vertical-align:middle;">
                        {{ floor($penilaians->where('kategori_nilai_id', 6)->where('mata_pelajaran_id', $mapelb->mata_pelajaran_id)->avg('nilai')) }}
                    </td>
                    <td style="text-align: justify; padding:10px;vertical-align:middle;">
                        @foreach ($penilaians->where('mata_pelajaran_id', $mapelb->mata_pelajaran_id) as $nilai)
                            @php
                                if ($nilai->nilai < 60) {
                                    $predikat_a = 'Perlu penguatan';
                                } elseif ($nilai->nilai < 70) {
                                    $predikat_a = 'Menunjukkan penguasaan yang cukup';
                                } elseif ($nilai->nilai < 80) {
                                    $predikat_a = 'Menunjukkan penguasaan yang baik';
                                } else {
                                    $predikat_a = 'Menunjukkan penguasaan yang sangat baik';
                                }
                            @endphp
                            @foreach ($listKd->where('mata_pelajaran_id', $mapelb->mata_pelajaran_id) as $kd)
                                @if ($kd->jenis_penilaian_id === $nilai->jenis_penilaian_id)
                                    {{ $predikat_a . ' dalam ' . $kd->deskripsi . '.' }}
                                @endif
                            @endforeach
                        @endforeach
                    </td>
                </tr>
            @endforeach
            @foreach ($kelompok_c as $mapelc)
                <tr style="page-break-inside: avoid; height: 150px;">
                    <td style="text-align: center; vertical-align:middle;">{{ $loop->iteration + 10 }}</td>
                    <td style="text-align: left; vertical-align:middle;padding-left: 10px;">{{ $mapelc->mapel->nama }}
                    </td>
                    <td style="text-align: center; vertical-align:middle;">
                        {{ floor($penilaians->where('kategori_nilai_id', 6)->where('mata_pelajaran_id', $mapelc->mata_pelajaran_id)->avg('nilai')) }}
                    </td>
                    <td style="text-align: justify; padding:10px;vertical-align:middle;">
                        @foreach ($penilaians->where('mata_pelajaran_id', $mapelc->mata_pelajaran_id) as $nilai)
                            @php
                                if ($nilai->nilai < 60) {
                                    $predikat_a = 'Perlu penguatan';
                                } elseif ($nilai->nilai < 70) {
                                    $predikat_a = 'Menunjukkan penguasaan yang cukup';
                                } elseif ($nilai->nilai < 80) {
                                    $predikat_a = 'Menunjukkan penguasaan yang baik';
                                } else {
                                    $predikat_a = 'Menunjukkan penguasaan yang sangat baik';
                                }
                            @endphp
                            @foreach ($listKd->where('mata_pelajaran_id', $mapelc->mata_pelajaran_id) as $kd)
                                @if ($kd->jenis_penilaian_id === $nilai->jenis_penilaian_id)
                                    {{ $predikat_a . ' dalam ' . $kd->deskripsi . '.' }}
                                @endif
                            @endforeach
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="page-break-before: always"></div>
    <div style="padding:5px;"></div>
    <table class="table">
        <thead>
            <tr class="bg-slate" style="font-weight: bold;">
                <th width="5%">No</th>
                <th width="30%">Ekstrakurikuler</th>
                {{-- <th width="10%">Nilai</th> --}}
                <th width="55%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @if ($penilaianEkstrakurikuler->nilai != null)
                <tr>
                    <td class="ctr" style="vertical-align:middle;">1.</td>
                    <td style="vertical-align:middle;">{{ $penilaianEkstrakurikuler->ekstrakurikuler->nama }}</td>
                    {{-- <td class="ctr">{{ $penilaianEkstrakurikuler->nilai }}</td> --}}
                    <td style="padding: 10px;">
                        @if ($penilaianEkstrakurikuler->nilai > 90)
                            Menunjukkan penguasaan yang sangat baik dalam
                            {{ $penilaianEkstrakurikuler->ekstrakurikuler->deskripsi->deskripsi }}
                        @elseif ($penilaianEkstrakurikuler->nilai > 80)
                            Menunjukkan penguasaan yang baik dalam
                            {{ $penilaianEkstrakurikuler->ekstrakurikuler->deskripsi->deskripsi }}
                        @elseif ($penilaianEkstrakurikuler->nilai > 70)
                            Menunjukkan penguasaan yang cukup dalam
                            {{ $penilaianEkstrakurikuler->ekstrakurikuler->deskripsi->deskripsi }}
                        @else
                            Perlu bimbingan dalam
                            {{ $penilaianEkstrakurikuler->ekstrakurikuler->deskripsi->deskripsi }}
                        @endif
                    </td>
                </tr>
            @else
                <tr>
                    <td class="ctr" style="vertical-align:middle;">-</td>
                    <td style="vertical-align:middle;">-</td>
                    {{-- <td class="ctr">{{ $penilaianEkstrakurikuler->nilai }}</td> --}}
                    <td style="padding: 10px;">
                        -
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    <div style="padding:5px;"></div>
    <table class="table" style="width: 50%;">
        <thead>
            <tr class="bg-slate">
                <td colspan="2" style="font-weight: bold; text-align:center;">Ketidakhadiran</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="60%">Sakit</td>
                <td width="40%" class="ctr"> {{ round($absensis->where('kehadiran_id', 2)->count() / 4) ?? '-' }}
                    hari</td>
            </tr>
            <tr>
                <td>Izin</td>
                <td class="ctr"> {{ round($absensis->where('kehadiran_id', 3)->count() / 4) ?? '-' }} hari</td>
            </tr>
            <tr>
                <td>Tanpa Keterangan</td>
                <td class="ctr"> {{ $alpha == 0 ? '-' : $alpha }} hari</td>
            </tr>
            </tr>
        </tbody>
    </table>
    <div style="padding:5px;"></div>
    <b>Catatan Wali Kelas</b>
    <table class="table" style="width:100%;border:#000 1px solid">
        <tr>
            <td style="border:#000 1px solid;padding:10px">
                {{ $catatan }}
            </td>
        </tr>
    </table>
    <div style="padding:5px;"></div>
    @if ($tingkat == 9 && $semester == 2)
        <p>
            <b>Keputusan</b> berdasarkan pencapaian kompetensi pada semester ke-1 sampai dengan ke-5, peserta didik
            ditetapkan *)
        </p>
        <p>
            @switch($naik)
                @case(1)
                    Lulus<br>
                    <s>
                        Tidak Lulus
                    </s>
                @break

                @case(2)
                    <s>
                        Lulus
                    </s>
                    <br>
                    Tidak Lulus
                @break

                @default
            @endswitch
            <br>
            *) Coret yang tidak perlu
        </p>
    @elseif ($semester == 2)
        <p>
            <b>Keputusan</b> berdasarkan pencapaian kompetensi pada semester ke-1 dan ke-2, peserta didik ditetapkan *)
        </p>
        <p>
            @switch($naik)
                @case(1)
                    Naik Kelas<br>
                    <s>
                        Tinggal Kelas
                    </s>
                @break

                @case(2)
                    <s>
                        Naik Kelas
                    </s>
                    <br>
                    Tinggal Kelas
                @break

                @default
            @endswitch
            <br>
            *) Coret yang tidak perlu
        </p>
    @else
    @endif
    <div style="padding:15px;"></div>
    <table style="text-align:center;table-layout:fixed;" width="100%">
        <tr>
            <td style="text-align:center">Mengetahui</td>
            <td style="text-align:center">
                Ngampel,
                @isset($tanggalRapor->tanggal)
                    {{ tanggal($tanggalRapor->tanggal) }}
                @endisset
            </td>
        </tr>
        <tr>
            <td style="text-align:center">Orang Tua/Wali</td>
            <td style="text-align:center">Wali Kelas</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align:center"><u><b>..........................</b></u></td>
            <td style="text-align:center"><u><b>{{ $namaWaliKelas }}</b></u></td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align:center" colspan="2">Mengetahui,</td>
        </tr>
        <tr>
            <td style="text-align:center" colspan="2">Kepala Sekolah</td>
        </tr>
        <tr>
            <td style="text-align:center" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align:center" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align:center" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align:center" colspan="2">&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align:center" colspan="2"><u><b>
                        {{ $namaKepalaSekolah }}
                        <br>
                    </b>
            </td>
        </tr>
    </table>
</body>

</html>
