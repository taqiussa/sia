@extends('print')
@section('title', 'Kwitansi -')
@section('content')
    <div class="text-sm">

        <div class="capitalize">
            telah terima dari
        </div>
        <div class="grid grid-cols-2 capitalize">
            <div class="grid grid-cols-3">
                <div>nama</div>
                <div class="col-span-2 font-bold">: {{ $siswa }}</div>
            </div>
        </div>
        <div class="grid grid-cols-2 capitalize">
            <div class="grid grid-cols-3">
                <div>kelas</div>
                <div class="col-span-2">: {{ $kelas }} - T.A. {{ $tahun }}</div>
            </div>
        </div>
        <div class="grid grid-cols-2 capitalize">
            <div class="grid grid-cols-3">
                <div>tanggal bayar</div>
                <div class="col-span-2">: {{ tanggal($transaksi->tanggal) }}</div>
            </div>
        </div>
        <div class="py-3"></div>
        <div class="flex justify-center">
            <table class="w-4/5">
                <thead>
                    <tr>
                        <th class="pl-3 text-left">Guna Bayar</th>
                        <th class="pl-3 text-left">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list_pembayaran as $pembayaran)
                        <tr>
                            <td class="pl-3">{{ $loop->iteration . '. ' . $pembayaran->gunabayar->nama }}
                            </td>
                            <td class="pl-3">{{ rupiah($pembayaran->jumlah) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="pl-3 font-bold">Total</td>
                        <td class="pl-3 font-bold">{{ rupiah($transaksi->jumlah) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="py-3"></div>
        <div class="grid grid-cols-2 gap-0">
            <div class="capitalize text-sm">
                <div class="grid grid-cols-2">
                    <div>keterangan</div>
                </div>
                <div class="grid grid-cols-2">
                    <div>administrasi 1 tahun</div>
                    <div>: {{ rupiah($wajibbayar) }}</div>
                </div>
                <div class="grid grid-cols-2">
                    <div>total bayar</div>
                    <div>: {{ rupiah($totalbayar) }}</div>
                </div>
                <div class="grid grid-cols-2">
                    <div>kurang bayar</div>
                    <div>: {{ rupiah($kurangbayar) }}</div>
                </div>
            </div>
            <div class="text-center">
                <div>Kendal, {{ tanggal($transaksi->tanggal) }}</div>
                <div>Bendahara</div>
                <div class="py-5"></div>
                <div class="font-bold">{{ $transaksi->user->name }}</div>
            </div>
        </div>
    </div>
@endsection
