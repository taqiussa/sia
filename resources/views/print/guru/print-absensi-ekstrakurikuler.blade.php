<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Pembayaran Siswa</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif !important;
            font-size: 11pt;
            margin-top: 15px;
            margin-bottom: 5px;
            margin-left: 10px;
            margin-right: 10px;
        }

        @page {
            margin-top: 15px;
            margin-bottom: 5px;
            margin-left: 10px;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <table align="center" style="padding:5px; text-align:center;line-height:1px;width:100%">
        <tbody>
            <tr>
                <td style="text-align: right"><img src="{{ asset('images/logoalfahp.png') }}" alt="logo"
                        style="width: 75px"></td>
                <td style="text-align: center;word-wrap:break-word;border-bottom:solid 2px #000">
                    <div style="margin-bottom: 15px"><strong>YAYASAN AL MUSYAFFA'</strong></div>
                    <div style="margin-bottom: 15px"><strong>SMP AL MUSYAFFA' KENDAL</strong></div>
                    <div style="margin-bottom: 15px">Jln. Kampir-Sudipayung, Kec. Ngampel, Kab. Kendal - Jawa Tengah
                    </div>
                    <div style="margin-bottom: 15px"> Hp: 0822-8000-1111 E-mail : smpalmusyaffa@gmail.com Website :
                        www.smpalmusyaffa.com </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div style="text-align: center">
        <h4>LAPORAN ABSENSI EKSTRAKURIKULER</h4>
    </div>
    <table style="width:100%">
        <tr>
            <th style="width: 25%; text-align:left">Nama Ekstrakurikuler</th>
            <th style="width: 1%">:</th>
            <th style="width: 30%; text-align:left">{{ $namaEkstrakurikuler }}</th>
            <th style="width: 10%">&nbsp;</th>
            <th style="width: 15%; text-align:left">Tahun</th>
            <th style="width: 1%">:</th>
            <th style="width: 18%; text-align:left">{{ $tahun }}</th>
        </tr>
        <tr>
            <th style="width: 25%; text-align:left">Tanggal Absensi</th>
            <th style="width: 1%">:</th>
            <th style="width: 30%; text-align:left">{{ hariTanggal($tanggal) }}
            </th>
            <th style="width: 10%">&nbsp;</th>
            <th style="width: 15%; text-align:left">Semester</th>
            <th style="width: 1%">:</th>
            <th style="width: 18%; text-align:left">{{ $semester }}</th>
        </tr>
    </table>
    <table style="width: 100%;border:#000 solid 1px;border-collapse:collapse">
        <thead>
            <tr>
                <th style="border:#000 solid 1px;padding:5px">#</th>
                <th style="border:#000 solid 1px;padding:5px">Nama</th>
                <th style="border:#000 solid 1px;padding:5px">Kelas</th>
                <th style="border:#000 solid 1px;padding:5px">Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listSiswa as $siswa)
                <tr>
                    <td style="border:#000 solid 1px;border-collapse:collapse; padding:5px; text-align:center">
                        {{ $loop->iteration }}</td>
                    <td style="border:#000 solid 1px;border-collapse:collapse; padding:5px">{{ $siswa->user->name }}
                    </td>
                    <td style="border:#000 solid 1px;border-collapse:collapse; padding:5px; text-align:center">
                        {{ $siswa->kelas->nama }}</td>
                    <td style="border:#000 solid 1px;border-collapse:collapse; padding:5px">
                        {{ $siswa->absensi->kehadiran->nama }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- <div style="padding: 15"></div>
<table style="padding-left: 25px;text-align:center" width="100%">
    <tr>
        <td colspan="2"></td>
        <td style="text-align:center">
            Ngampel, {{ Carbon\Carbon::parse(gmdate('Y-m-d'))->translatedFormat('d F Y') }}
        </td>
    </tr>
    <tr>
        <td style="text-align:center">Waka.Ur Kesiswaan</td>
        <td style="width: 35%"></td>
        <td style="text-align:center">Pembina Ekstrakurikuler</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
    <tr>
        <td style="text-align:center">
            <b>
                {{ $kesiswaan[0]->name }}
            </b>
        </td>
        <td></td>
        <td style="text-align:center">
            <b>
                {{ auth()->user()->name }}
            </b>
        </td>
    </tr>
    <tr>
        <td colspan="3" style="text-align:center">Mengetahui :</td>
    </tr>
    <tr>
        <td colspan="3" style="text-align:center">Kepala SMP Al Musyaffa'</td>
    </tr>
    <tr>
        <td colspan="3" style="text-align:center">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" style="text-align:center">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" style="text-align:center">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" style="text-align:center">&nbsp;</td>
    </tr>
    <tr>
        <td colspan="3" style="text-align:center">
            <b>
                @foreach ($kepala_sekolah as $kasek)
                    {{ $kasek->name }}
                @endforeach
            </b>
        </td>
    </tr>
</table> --}}
</body>

</html>
