<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Harian Pemasukan</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif !important;
            font-size: 12pt;
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
    <div style="text-align: center">
        <h4>LAPORAN HARIAN PEMASUKAN SEKOLAH</h4>
    </div>
    <h4>
        Hari, Tanggal : {{ hariTanggal($tanggalAwal) }}
        sampai dengan
        {{ hariTanggal($tanggalAkhir) }}
    </h4>
    <h4>Pembayaran Siswa</h4>
    <table border="1" style="width:100%;border-collapse: collapse;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Gunabayar</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listPembayaran as $key => $pembayaran)
                <tr align="center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ tanggal($pembayaran->tanggal) }}</td>
                    <td align="left" style="padding-left: 5px">{{ $pembayaran->siswa->name }}</td>
                    <td>{{ $pembayaran->kelas->nama }}</td>
                    <td>{{ $pembayaran->gunabayar->nama }}</td>
                    <td align="right" style="padding-left: 5px;padding-right: 5px">
                        {{ rupiah($pembayaran->jumlah) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" style="padding: 5px"><b>Subtotal</b></td>
                <td align="right" style="padding: 5px">
                    <b>{{ rupiah($subtotalPembayaran) }}</b>
                </td>
            </tr>
        </tbody>
    </table>
    <h4>Pemasukan</h4>
    <table border="1" style="width:100%;border-collapse: collapse;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Kategori Pemasukan</th>
                <th>Keterangan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listPemasukan as $key => $pemasukan)
                <tr align="center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('d M Y', strtotime($pemasukan->tanggal)) }}</td>
                    <td align="left" style="padding-left: 5px">{{ $pemasukan->kategori->nama }}</td>
                    <td align="left" style="padding-left: 5px">{{ $pemasukan->keterangan }}</td>
                    <td align="right" style="padding-left: 5px;padding-right: 5px">
                        {{ rupiah($pemasukan->jumlah) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" style="padding: 5px"><b>Subtotal</b></td>
                <td align="right" style="padding: 5px">
                    <b>{{ rupiah($subtotalPemasukan) }}</b>
                </td>
            </tr>
        </tbody>
    </table>
    <h4>Grand Total</h4>
    <table border="1" style="width: 100%;border-collapse:collapse;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal Awal</th>
                <th>Tanggal Akhir</th>
                <th>Keterangan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td align="center">1.</td>
                <td style="padding-left: 5px; text-align:center">{{ hariTanggal($tanggalAwal) }}</td>
                <td style="padding-left: 5px; text-align:center">{{ hariTanggal($tanggalAkhir) }}</td>
                <td style="padding-left: 5px"><b>Pembayaran Siswa</b></td>
                <td style="padding-right: 5px; text-align:right;"><b>{{ rupiah($subtotalPembayaran) }}</b></td>
            </tr>
            <tr>
                <td align="center">2.</td>
                <td style="padding-left: 5px; text-align:center">{{ hariTanggal($tanggalAwal) }}</td>
                <td style="padding-left: 5px; text-align:center">{{ hariTanggal($tanggalAkhir) }}</td>
                <td style="padding-left: 5px"><b>Pemasukan</b></td>
                <td style="padding-right: 5px; text-align:right;"><b>{{ rupiah($subtotalPemasukan) }}</b></td>
            </tr>
            <tr>
                <td colspan="4" style="padding-left: 5px">
                    <h3>Total</h3>
                </td>
                <td style="text-align: right;padding-right: 5px">
                    <h3>{{ rupiah($total) }}</h3>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
