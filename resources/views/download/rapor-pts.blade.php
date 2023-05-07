<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RAPOR PTS</title>
    <style type="text/css">
        body {
            font-family: 'Times New Roman', Times, serif !important;
            font-size: 12pt;
        }

        .table {
            border-collapse: collapse;
            border: solid 1px #999;
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
        }
    </style>
</head>

<body>
    <div style="text-align: center">
        <h4>PENCAPAIAN KOMPETENSI AKADEMIK PESERTA DIDIK</h4>
        <h4>PENILAIAN TENGAH SEMESTER
            @if ($semester == 1)
                {{ 'GASAL' }}
            @else
                {{ 'GENAP' }}
            @endif
            TAHUN PELAJARAN {{ $tahun }}
        </h4>
    </div>
    <hr>
    <table style="text-align:justify">
        <tbody>
            <tr>
                <td width="20%">Nama Sekolah</td>
                <td width="1%">:</td>
                <td width="39%">SMP Al Musyaffa Kendal</td>
                <td style="padding-left: 100px" width="15%">Kelas</td>
                <td width="1%">:</td>
                <td width="10%">{{ $namaKelas }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>Jl. Kampir Sudipayung, Kec. Ngampel, Kab. Kendal</td>
                <td style="padding-left: 100px">Semester</td>
                <td>:</td>
                <td>{{ $semester }}</td>
            </tr>
            <tr>
                <td>Nama Siswa</td>
                <td>:</td>
                <td>{{ $namaSiswa }}</td>
                <td style="padding-left: 100px">Tahun</td>
                <td>:</td>
                <td>{{ $tahun }}</td>
            </tr>
        </tbody>
    </table>
    <div style="padding:5px;"></div>
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Mata Pelajaran</th>
                @foreach ($listJenis as $jenis)
                    <th>
                        {{ $jenis->jenis->nama }}
                    </th>
                @endforeach
                <th>
                    Rata - Rata
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="6" style="text-align: left">Kelompok A</td>
            </tr>
            @foreach ($kelompok_a as $mapel)
                <tr>
                    <td style="text-align: center">{{ $loop->iteration }}</td>
                    <td style="text-align: left">{{ $mapel->mapel->nama }}</td>
                    @foreach ($listJenis as $jenis)
                        <td style="text-align: center">
                            {{ $penilaians->where('mata_pelajaran_id', $mapel->mata_pelajaran_id)->where('jenis_penilaian_id', $jenis->jenis_penilaian_id)->value('nilai') }}
                        </td>
                    @endforeach
                    <td style="text-align: center">
                        {{ floor($penilaians->where('mata_pelajaran_id', $mapel->mata_pelajaran_id)->whereIn('jenis_penilaian_id', $listJenis->pluck('jenis_penilaian_id'))->avg('nilai')) }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6" style="text-align: left">Kelompok B</td>
            </tr>
            @foreach ($kelompok_b as $mapel)
                <tr>
                    <td style="text-align: center">{{ $loop->iteration }}</td>
                    <td style="text-align: left">{{ $mapel->mapel->nama }}</td>
                    @foreach ($listJenis as $jenis)
                        <td style="text-align: center">
                            {{ $penilaians->where('mata_pelajaran_id', $mapel->mata_pelajaran_id)->where('jenis_penilaian_id', $jenis->jenis_penilaian_id)->value('nilai') }}
                        </td>
                    @endforeach
                    <td style="text-align: center">
                        {{ floor($penilaians->where('mata_pelajaran_id', $mapel->mata_pelajaran_id)->whereIn('jenis_penilaian_id', $listJenis->pluck('jenis_penilaian_id'))->avg('nilai')) }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6" style="text-align: left">Kelompok C</td>
            </tr>
            @foreach ($kelompok_c as $mapel)
                <tr>
                    <td style="text-align: center">{{ $loop->iteration }}</td>
                    <td style="text-align: left">{{ $mapel->mapel->nama }}</td>
                    @foreach ($listJenis as $jenis)
                        <td style="text-align: center">
                            {{ $penilaians->where('mata_pelajaran_id', $mapel->mata_pelajaran_id)->where('jenis_penilaian_id', $jenis->jenis_penilaian_id)->value('nilai') }}
                        </td>
                    @endforeach
                    <td style="text-align: center">
                        {{ floor($penilaians->where('mata_pelajaran_id', $mapel->mata_pelajaran_id)->whereIn('jenis_penilaian_id', $listJenis->pluck('jenis_penilaian_id'))->avg('nilai')) }}
                    </td>
                </tr>
            @endforeach
            {{-- <tr>
                <td colspan="2"></td>
                @foreach ($listJenis as $jenis)
                    <td style="text-align: center">
                        @php
                            $total = App\Models\Penilaian::where('tahun', $tahun)
                                ->where('semester', $semester)
                                ->where('jenis_penilaian_id', $jenis->jenis_penilaian_id)
                                ->where('nis', $nis)
                                ->sum('nilai');
                        @endphp
                        {{ $total }}
                    </td>
                @endforeach
            </tr> --}}
        </tbody>
    </table>
    <div style="padding:15px;"></div>
    <table align="right" style="padding-left: 65px;text-align:center">
        <tr>
            <td style="text-align:center">
                Ngampel, {{ tanggal(date('Y-m-d')) }}
            </td>
        </tr>
        <tr>
            <td style="text-align:center">Wali Kelas</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td style="text-align:center">
                    <u>
                        <b>
                            {{ $namaWaliKelas }}
                        </b>
                    </u>
            </td>
        </tr>
    </table>
</body>

</html>
