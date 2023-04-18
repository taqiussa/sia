<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Harian Pengeluaran</title>
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
        <h4>LAPORAN HARIAN PENGELUARAN SEKOLAH</h4>
    </div>
    <h4>
        Hari, Tanggal : {{ hariTanggal($tanggalAwal) }}
        sampai dengan
        {{ hariTanggal($tanggalAkhir) }}
    </h4>
    <h4>Pengeluaran</h4>
    <table border="1" style="width:100%;border-collapse: collapse;">
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>Kategori Pengeluaran</th>
                <th>Keterangan</th>
                <th>Tanggal Nota</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listPengeluaran as $pengeluaran)
                <tr align="center">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ tanggal($pengeluaran->tanggal) }}</td>
                    <td align="left" style="padding-left: 5px">{{ $pengeluaran->kategori->nama }}</td>
                    <td align="left" style="padding-left: 5px">{{ $pengeluaran->keterangan }}</td>
                    <td align="left" style="padding-left: 5px">{{ tanggal($pengeluaran->tanggal_nota) }}</td>
                    <td align="right" style="padding-left: 5px;padding-right: 5px">
                        {{ rupiah($pengeluaran->jumlah) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="5" style="padding: 5px"><b>Total</b></td>
                <td align="right" style="padding: 5px">
                    <b>{{ rupiah($total) }}</b>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
