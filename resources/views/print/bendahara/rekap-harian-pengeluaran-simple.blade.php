@extends('print')
@section('title', 'Rekap Harian Pengeluaran -')
@section('content')
    <div class="text-center font-bold text-md mb-2">
        <h4>LAPORAN HARIAN PENGELUARAN SEKOLAH</h4>
    </div>
    <div class="grid grid-cols-4">
        <div>
            Hari, Tanggal
        </div>
        <div class="col-span-2">
            : {{ hariTanggal($tanggalAwal) }}
        </div>
    </div>
    <div class="grid grid-cols-4">
        <div>
            Sampai Dengan
        </div>
        <div class="col-span-2">
            : {{ hariTanggal($tanggalAkhir) }}
        </div>
    </div>
    <div class="mt-3 mb-2 font-bold text-lg">Pengeluaran</div>
    <table class="w-full border-2 border-collapse border-black">
        <thead>
            <tr class="border-2 border-collapse border-black">
                <th>No.</th>
                <th>Kategori Pengeluaran</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listKategori as $key => $kategori)
                <tr class="border-2 border-collapse border-black">
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="pl-3">{{ $kategori->nama }}</td>
                    <td>
                        {{ rupiah($kategori->pengeluaran->sum('jumlah')) }}
                    </td>
                </tr>
            @endforeach
            <tr class="bg-slate-200 font-bold text-md">
                <td class="pl-3" colspan="2">
                    Total
                </td>
                <td>
                    <h3>{{ rupiah($total) }}</h3>
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
