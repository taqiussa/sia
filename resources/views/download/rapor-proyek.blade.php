<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rapor - Proyek</title>
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

            /* div.header-space {
                height: 100px;
            } */
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
    </style>
</head>

<body>
    <footer>
        {{ $namaSiswa }} | {{ $nis }} | Kelas : {{ $namaKelas }} | {{ $tahun }}
    </footer>
    <div style="text-align: center">
        <h4 style=" letter-spacing:0.2em;">RAPOR PROJEK PENGUATAN
            <br>
            PROFIL PELAJAR PANCASILA
        </h4>
    </div>
    <div style="padding:10px"></div>
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
                <td>Fase</td>
                <td>:</td>
                <td>D</td>
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

    @foreach ($listProyek->unique('proyek_id') as $proyek)
        <br>
        <br>
        <b>{{ $proyek->proyek->nama }} {{ $proyek->judul }}</b>
        <div style="padding:5px;"></div>
        <table style="border-collapse: collapse" width="100%">
            <tbody>
                <tr>
                    <td style="border: solid 1px #000; padding: 10px;text-align:justify">{{ $proyek->deskripsi }}.</td>
                </tr>
            </tbody>
        </table>
    @endforeach


    @foreach ($listProyek->unique('proyek_id') as $proyek)
        <div style="page-break-before: always"></div>
        <table style="border-collapse: collapse" width="100%">
            <thead>
                <tr>
                    <th style="border: solid 1px #000; padding: 10px;text-align:left; font-weight:bold">
                        {{ $proyek->proyek->nama }} {{ $proyek->judul }}</th>
                    <th style="border: solid 1px #000; padding: 10px;text-align:center; font-weight:bold">BB</th>
                    <th style="border: solid 1px #000; padding: 10px;text-align:center; font-weight:bold">MB</th>
                    <th style="border: solid 1px #000; padding: 10px;text-align:center; font-weight:bold">BSH</th>
                    <th style="border: solid 1px #000; padding: 10px;text-align:center; font-weight:bold">SB</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listProyek->where('proyek_id', $proyek->proyek_id) as $dimensi)
                    <tr>
                        <td style="border: solid 1px #000; padding: 10px;text-align:left; font-weight:bold"
                            colspan="5">
                            {{ $dimensi->dimensi->nama }}
                        </td>
                    </tr>
                    <tr>
                        <td style="border: solid 1px #000; padding: 10px;text-align:justify; vertical-align:middle;">
                            <b>
                                {{ $dimensi->subElemen->nama }} -
                            </b>
                            {{ $dimensi->capaian }}.
                        </td>
                        @php
                            $nilai = $penilaian
                                ->where('proyek_id', $dimensi->proyek_id)
                                ->where('dimensi_id', $dimensi->dimensi_id)
                                ->value('nilai');
                        @endphp
                        <td
                            style="width:45px; border: solid 1px #000; padding: 3px;text-align:center; vertical-align:middle; font-weight:bold">
                            @if ($nilai <= 73)
                                <img src="{{ asset('images/check.png') }}" />
                            @endif
                        </td>
                        <td
                            style="width:45px; border: solid 1px #000; padding: 3px;text-align:center; vertical-align:middle; font-weight:bold">
                            @if ($nilai >= 74 && $nilai <= 82)
                                <img src="{{ asset('images/check.png') }}" />
                            @endif
                        </td>
                        <td
                            style="width:45px; border: solid 1px #000; padding: 3px;text-align:center; vertical-align:middle; font-weight:bold">
                            @if ($nilai >= 83 && $nilai <= 91)
                                <img src="{{ asset('images/check.png') }}" />
                            @endif
                        </td>
                        <td
                            style="width:45px; border: solid 1px #000; padding: 3px;text-align:center; vertical-align:middle; font-weight:bold">
                            @if ($nilai >= 92)
                                <img src="{{ asset('images/check.png') }}" />
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <b>Catatan Proses</b>
        <br>
        <div style="padding:5px;"></div>
        <table style="border-collapse: collapse" width="100%">
            <tbody>
                <tr>
                    <td style="border: solid 1px #000; padding: 10px;text-align:justify">
                        @php
                            $penilaianProyek = $penilaian->where('proyek_id', $proyek->proyek_id);
                            $maxValue = $penilaianProyek->pluck('nilai')->max();
                            $minValue = $penilaianProyek->pluck('nilai')->min();
                            
                            $maxDimensi = $penilaianProyek->where('nilai', $maxValue)->value('dimensi_id');
                            $minDimensi = $penilaianProyek->where('nilai', $minValue)->value('dimensi_id');
                        @endphp
                        Dalam mengerjakan projek ini, {{ ucwords(strtolower($namaSiswa)) }}
                        @if ($maxValue <= 73)
                            belum aktif
                        @elseif ($maxValue <= 83)
                            mulai aktif
                        @else
                            aktif
                        @endif

                        {{ $listProyek->where('proyek_id', $proyek->proyek_id)->where('dimensi_id', $maxDimensi)->first()->catatan }}.

                        {{ ucwords(strtolower($namaSiswa)) }}
                        @if ($minValue <= 73)
                            belum aktif
                        @elseif ($minValue <= 83)
                            mulai aktif
                        @else
                            aktif
                        @endif
                        {{ $listProyek->where('proyek_id', $proyek->proyek_id)->where('dimensi_id', $minDimensi)->first()->catatan }}.
                    </td>
                </tr>
            </tbody>
        </table>
    @endforeach
    <div style="padding:10px;"></div>
    <div style="text-align: center">
        <b>KETERANGAN TINGKAT PENCAPAIAN SISWA</b>
    </div>
    <div style="padding:10px;"></div>
    <table style="border-collapse: collapse" width="100%">
        <thead>
            <tr>
                <th style="border: solid 1px #000; padding: 10px;text-align:center;font-weight:bold">BB</th>
                <th style="border: solid 1px #000; padding: 10px;text-align:center;font-weight:bold">MB</th>
                <th style="border: solid 1px #000; padding: 10px;text-align:center;font-weight:bold">BSH</th>
                <th style="border: solid 1px #000; padding: 10px;text-align:center;font-weight:bold">SB</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border: solid 1px #000; padding: 10px;text-align:center">Belum Berkembang</td>
                <td style="border: solid 1px #000; padding: 10px;text-align:center">Mulai Berkembang</td>
                <td style="border: solid 1px #000; padding: 10px;text-align:center">Berkembang Sesuai Harapan</td>
                <td style="border: solid 1px #000; padding: 10px;text-align:center">Sangat Berkembang</td>
            </tr>
            <tr>
                <td style="border: solid 1px #000; padding: 10px;text-align:center">Siswa masih membutuhkan bimbingan
                    dalam mengembangkan kemampuan</td>
                <td style="border: solid 1px #000; padding: 10px;text-align:center">Siswa mulai mengembangkan kemampuan
                    namun masih belum ajek</td>
                <td style="border: solid 1px #000; padding: 10px;text-align:center">Siswa telah mengembangkan kemampuan
                    hingga berada dalam tahap ajek</td>
                <td style="border: solid 1px #000; padding: 10px;text-align:center">Siswa mengembangkan kemampuannya
                    melampaui harapan</td>
            </tr>
        </tbody>
    </table>
    <div style="padding:10px;"></div>
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
            <td style="text-align:center" colspan="2"><u><b>
                        {{ $namaKepalaSekolah }}
                        <br>
                    </b>
            </td>
        </tr>
    </table>
</body>

</html>
