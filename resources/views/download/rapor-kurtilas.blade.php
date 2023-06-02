<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rapor - Kurtilas</title>
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
    <br>
    <b>A. SIKAP</b>
    <div style="padding:5px;"></div>
    <table style="border-collapse: collapse" width="100%">
        <tbody>
            <tr>
                <td width="35.7%" style="border: solid 1px #000; padding: 10px">Dimensi</td>
                <td width="64.3%" style="border: solid 1px #000; padding: 10px">Deskripsi</td>
            </tr>
            @foreach ($listSikap as $sikap)
                <tr style="height: 100px;">
                    @php
                        
                        $hasil = $penilaianSikaps->where('jenis_sikap_id', $sikap->id)->avg('nilai');
                        
                        if ($hasil > 90) {
                            $predikat = 'menunjukkan penguasaan yang sangat baik';
                        } elseif ($hasil > 80) {
                            $predikat = 'menunjukkan penguasaan yang baik';
                        } elseif ($hasil > 70) {
                            $predikat = 'menunjukkan penguasaan yang cukup';
                        } else {
                            $predikat = 'perlu penguatan';
                        }
                    @endphp
                    <td style="border: solid 1px #000; padding: 10px ; vertical-align:middle;">
                        {{ $sikap->nama }}
                    </td>
                    <td style="border: solid 1px #000; padding: 10px; text-align:justify;vertical-align:middle;">
                        @switch($sikap->id)
                            @case(11)
                                Dalam penguatan dimensi beriman, bertakwa, dan berakhlak mulia, {{ $namaSiswa }}
                                {{ $predikat }} dalam elemen akhlak bernegara, akhlak kepada alam, akhlak beragama, akhlak
                                kepada sesama manusia dan akhlak pribadi
                            @break

                            @case(12)
                                Dalam penguatan dimensi berkebinekaan global, {{ $namaSiswa }}
                                {{ $predikat }} dalam elemen mengenal dan menghargai budaya, refleksi dan tanggung jawab
                                terhadap pengalaman kebinekaan, komunikasi dan interaksi antar budaya dan berkeadilan sosial
                            @break

                            @case(13)
                                Dalam penguatan dimensi bergotong royong, {{ $namaSiswa }} {{ $predikat }} dalam elemen
                                kepedulian, kolaborasi dan berbagi
                            @break

                            @case(14)
                                Dalam penguatan dimensi mandiri, {{ $namaSiswa }} {{ $predikat }} dalam elemen
                                regulasi diri, pemahaman diri dan situasi
                            @break

                            @case(15)
                                Dalam penguatan dimensi bernalar kritis, {{ $namaSiswa }} {{ $predikat }} dalam elemen
                                menganalisis dan mengevaluasi penalaran, memperoleh dan memproses informasi gagasan, merefleksi
                                dan mengevaluasi pemikirannya sendiri
                            @break

                            @case(16)
                                Dalam penguatan dimensi kreatif, {{ $namaSiswa }} {{ $predikat }} dalam elemen
                                memiliki keluwesan berpikir dalam mencari alternatif solusi permasalahan, menghasilkan gagasan
                                yang orisinal, menghasilkan karya dan tindakan yang orisinial
                            @break

                            @default
                        @endswitch
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="page-break-before: always"></div>
    <b>B. PENGETAHUAN DAN KETERAMPILAN</b>
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Mata Pelajaran</th>
                <th width="8%">Nilai</th>
                <th width="46%">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="4" style="text-align: left">Kelompok A</td>
            </tr>
            @foreach ($kelompok_a as $mapel)
                <tr style="page-break-inside: avoid;height: 140px;">
                    <td style="text-align: center ; vertical-align:middle;">{{ $loop->iteration }}</td>
                    <td style="text-align: left ; vertical-align:middle;padding-left:10px;">{{ $mapel->mapel->nama }}
                    </td>
                    <td style="text-align: center ; vertical-align:middle;">
                        {{ floor($penilaians->where('mata_pelajaran_id', $mapel->mata_pelajaran_id)->avg('nilai')) }}
                    </td>
                    <td style="text-align: justify ;padding:10px;vertical-align:middle;">
                        @foreach ($penilaians->where('mata_pelajaran_id', $mapel->mata_pelajaran_id) as $nilai)
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
                            @foreach ($listKd->where('mata_pelajaran_id', $mapel->mata_pelajaran_id) as $kd)
                                @if ($kd->jenis_penilaian_id === $nilai->jenis_penilaian_id)
                                    {{ $predikat_a . ' dalam ' . $kd->deskripsi . '.' }}
                                @endif
                            @endforeach
                        @endforeach
                    </td>
                </tr>
            @endforeach
            <tr style="page-break-before: always">
                <td colspan="4" style="text-align: left">Kelompok B</td>
            </tr>
            @foreach ($kelompok_b as $mapel)
                <tr style="page-break-inside: avoid;height: 140px;">
                    <td style="text-align: center; vertical-align:middle;">{{ $loop->iteration + 7 }}</td>
                    <td style="text-align: left; vertical-align:middle;padding-left:10px;">{{ $mapel->mapel->nama }}
                    </td>
                    <td style="text-align: center; vertical-align:middle;">
                        {{ floor($penilaians->where('mata_pelajaran_id', $mapel->mata_pelajaran_id)->avg('nilai')) }}
                    </td>
                    <td style="text-align: justify; padding:10px; vertical-align:middle;">
                        @foreach ($penilaians->where('mata_pelajaran_id', $mapel->mata_pelajaran_id) as $nilai)
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
                            @foreach ($listKd->where('mata_pelajaran_id', $mapel->mata_pelajaran_id) as $kd)
                                @if ($kd->jenis_penilaian_id === $nilai->jenis_penilaian_id)
                                    {{ $predikat_a . ' dalam ' . $kd->deskripsi . '.' }}
                                @endif
                            @endforeach
                        @endforeach
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" style="text-align: left">Kelompok C</td>
            </tr>
            @foreach ($kelompok_c as $mapel)
                <tr style="page-break-inside: avoid;height: 140px;">
                    <td style="text-align: center ; vertical-align:middle;">{{ $loop->iteration + 10 }}</td>
                    <td style="text-align: left ; vertical-align:middle;padding-left:10px;">{{ $mapel->mapel->nama }}
                    </td>
                    <td style="text-align: center ; vertical-align:middle;">
                        {{ floor($penilaians->where('mata_pelajaran_id', $mapel->mata_pelajaran_id)->avg('nilai')) }}
                    </td>
                    <td style="text-align: justify; padding:10px; vertical-align:middle;">
                        @foreach ($penilaians->where('mata_pelajaran_id', $mapel->mata_pelajaran_id) as $nilai)
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
                            @foreach ($listKd->where('mata_pelajaran_id', $mapel->mata_pelajaran_id) as $kd)
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
    <b>C. EKSTRAKURIKULER</b>
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Nama Kegiatan</th>
                <th width="10%">Nilai</th>
                <th width="55%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @if ($penilaianEkstrakurikuler->nilai != null)
                <tr>
                    <td class="ctr" style=" vertical-align:middle;">1.</td>
                    <td style=" vertical-align:middle;padding-left:10px;">{{ $penilaianEkstrakurikuler->nilai }}</td>
                    <td class="ctr" style="vertical-align: middle;">{{ $penilaianEkstrakurikuler->nilai }}</td>
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
                    <td class="ctr" style=" vertical-align:middle;">-</td>
                    <td style=" vertical-align:middle;padding-left:10px;">-</td>
                    <td class="ctr" style="vertical-align: middle;">-</td>
                    <td style="padding: 10px;">
                        -
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    <div style="padding:5px;"></div>
    <b>D. KETIDAKHADIRAN</b>
    <table class="table">
        <tbody>
            <tr>
                <td width="60%" style="padding-left:10px;">Sakit</td>
                <td width="40%" class="ctr"> {{ round($absensis->where('kehadiran_id', 2)->count() / 4) >= 1 ? round($absensis->where('kehadiran_id', 2)->count() / 4) : '-' }}
                    hari</td>
            </tr>
            <tr>
                <td style="padding-left:10px;">Izin</td>
                <td class="ctr"> {{ round($absensis->where('kehadiran_id', 3)->count() / 4) >= 1 ? round($absensis->where('kehadiran_id', 3)->count() / 4) : '-' }} hari</td>
            </tr>
            <tr>
                <td style="padding-left:10px;">Tanpa Keterangan</td>
                <td class="ctr"> {{ $alpha == 0 ? '-' : $alpha }} hari</td>
            </tr>
            </tr>
        </tbody>
    </table>
    <div style="padding:5px;"></div>
    <b>E. PRESTASI</b>
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="30%">Jenis Prestasi</th>
                <th width="55%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($listPrestasi as $prestasi)
                <tr>
                    <td width="5%" style="text-align: center; vertical-align:middle;">{{ $loop->iteration }}</td>
                    <td width="40%" style="vertical-align: middle;padding:10px;">{{ $prestasi->prestasi }}</th>
                    <td width="55%" style="vertical-align: middle;padding:10px;">{{ $prestasi->keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td width="5%" style="text-align: center">-</td>
                    <td width="40%">-</th>
                    <td width="55%">-</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div style="padding:5px;"></div>
    <b>F. CATATAN WALIKELAS</b>
    <table class="table">
        <tr>
            <td style="border:#000 1px solid;padding:5px;">
                {{ $catatan }}
            </td>
        </tr>
    </table>
    <div style="padding:5px;"></div>
    {{-- <b>G. TANGGAPAN ORANGTUA/WALI</b>
    <table style="border-collapse:  collapse; border:#000 1px solid" width="100%">
        <tbody>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </tbody>
    </table> --}}
    @if ($tingkat == 9 && $semester == 2)
        <p>
            <b>Keputusan</b> berdasarkan pencapaian kompetensi pada semester ke-1 sampai dengan ke-6, peserta didik
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
