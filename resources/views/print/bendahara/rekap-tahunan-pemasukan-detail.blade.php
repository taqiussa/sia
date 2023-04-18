@extends('print')
@section('title', 'Rekap Tahunan Pemasukan -')
@section('content')
    <div class="text-center font-bold text-md mb-2">
        LAPORAN TAHUNAN PEMASUKAN SEKOLAH <br>
        TAHUN {{ $tahun }}
    </div>
    <div class="mt-3 mb-2 font-bold text-lg">Pembayaran Siswa</div>
    <table class="w-full border border-collapse border-black text-sm">
        <thead>
            <tr class="border border-collapse border-black">
                <th>No.</th>
                <th class="border border-collapse border-black">Tanggal</th>
                <th class="border border-collapse border-black">Nama Siswa</th>
                <th class="border border-collapse border-black">Kelas</th>
                <th class="border border-collapse border-black">Gunabayar</th>
                <th class="border border-collapse border-black">Bendahara</th>
                <th class="border border-collapse border-black">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listPembayaran as $pembayaran)
                <tr class="border border-collapse border-black">
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="border border-collapse border-black pl-1">{{ tanggalSingkat($pembayaran->tanggal) }}</td>
                    <td class="border border-collapse border-black pl-1">{{ $pembayaran->siswa->name }} </td>
                    <td class="border border-collapse border-black pl-1 text-center">{{ $pembayaran->kelas->nama }}</td>
                    <td class="border border-collapse border-black pl-1">{{ $pembayaran->gunabayar->nama }}</td>
                    <td class="border border-collapse border-black pl-1">{{ $pembayaran->user->name }}</td>
                    <td class="border border-collapse border-black pl-1">{{ rupiah($pembayaran->jumlah) }}</td>
                </tr>
            @endforeach
            <tr class="bg-slate-200 font-bold text-md">
                <td class="pl-3" colspan="5">
                    Subtotal
                </td>
                <td class="text-right pr-3" colspan="2">
                    {{ rupiah($subtotalPembayaran) }}
                </td>
            </tr>
        </tbody>
    </table>
    <div class="mt-3 mb-2 font-bold text-lg">Pemasukan</div>
    <table class="w-full border border-collapse border-black">
        <thead>
            <tr class="border border-collapse border-black">
                <th class="border border-collapse border-black">No.</th>
                <th class="border border-collapse border-black">Tanggal</th>
                <th class="border border-collapse border-black">Kategori Pemasukan</th>
                <th class="border border-collapse border-black">Keterangan</th>
                <th class="border border-collapse border-black">Bendahara</th>
                <th class="border border-collapse border-black">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listPemasukan as $pemasukan)
                <tr class="border border-collapse border-black">
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="border border-collapse border-black pl-1">{{ tanggalSingkat($pemasukan->tanggal) }}</td>
                    <td class="border border-collapse border-black pl-1">{{ $pemasukan->kategori->nama }}</td>
                    <td class="border border-collapse border-black pl-1">{{ $pemasukan->keterangan }}</td>
                    <td class="border border-collapse border-black pl-1">{{ $pemasukan->user->name }}</td>
                    <td class="border border-collapse border-black pl-1">{{ rupiah($pemasukan->jumlah) }}</td>
                </tr>
            @endforeach
            <tr class="bg-slate-200 font-bold text-md">
                <td class="pl-3" colspan="4">
                    Subtotal
                </td>
                <td class="text-right pr-3" colspan="2">
                    {{ rupiah($subtotalPemasukan) }}
                </td>
            </tr>
        </tbody>
    </table>
    <div class="mt-3 mb-2 font-bold text-lg">Grand Total</div>
    <table class="w-full border border-collapse border-black">
        <thead>
            <tr class="border border-collapse border-black">
                <th>No.</th>
                <th class="border border-collapse border-black">Keterangan</th>
                <th class="border border-collapse border-black">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border border-collapse border-black">
                <td class="text-center">1.</td>
                <td class="border border-collapse border-black pl-1">Pembayaran Siswa</td>
                <td class="border border-collapse border-black pl-1">{{ rupiah($subtotalPembayaran) }}</td>
            </tr>
            <tr class="border border-collapse border-black">
                <td class="text-center">2.</td>
                <td class="border border-collapse border-black pl-1">Pemasukan</td>
                <td class="border border-collapse border-black pl-1">{{ rupiah($subtotalPemasukan) }}</td>
            </tr>
            <tr class="bg-slate-200 font-bold text-md">
                <td class="pl-3" colspan="2">
                    Total
                </td>
                <td class="pl-1">
                    {{ rupiah($total) }}
                </td>
            </tr>
        </tbody>
    </table>
    <div class="flex justify-between pl-7 pr-3 py-3">
        <div class="flex flex-col text-center">
            <div>&nbsp;</div>
            <div>Kepala SMP Al Musyaffa</div>
            <div class="pt-16 font-bold">{{ $kepalaSekolah }}</div>
        </div>
        <div class="flex flex-col text-center">
            <div>
                Ngampel, {{ tanggal(date('Y-m-d')) }}
            </div>
            <div>Bendahara</div>
            <div class="pt-16 font-bold">{{ auth()->user()->name }}</div>
        </div>
    </div>
    <div class="flex flex-col text-center justify-center pt-2">
        <div>Mengetahui,</div>
        <div>Ketua Yayasan Al Musyaffa</div>
        <div class="pt-16 font-bold">KH. Muchlis Musyaffa'</div>
    </div>
@endsection
