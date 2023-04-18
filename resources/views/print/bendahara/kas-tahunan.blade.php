@extends('print')
@section('title', 'Rekap Harian Pemasukan -')
@section('content')
    <div class="text-center font-bold text-md mb-2 capitalize">
        laporan KAS tahun {{ request('tahun') }}
    </div>
    <div class="grid grid-cols-2 gap-2">
        <div>
            <div class="mt-3 mb-2 font-bold text-lg text-center">Pemasukan</div>
            <table class="w-full border border-collapse border-black">
                <thead>
                    <tr class="border border-collapse border-black">
                        <th class="border border-collapse border-black">No.</th>
                        <th class="border border-collapse border-black">Kategori Pemasukan</th>
                        <th class="border border-collapse border-black">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border border-collapse border-black">
                        <td class="text-center">1</td>
                        <td class="border border-collapse border-black pl-1">PEMBAYARAN SPP SISWA</td>
                        <td class="border border-collapse border-black pl-1">
                            {{ rupiah($totalSPP) }}
                        </td>
                    </tr>
                    @forelse ($listPemasukan as $pemasukan)
                        <tr class="border border-collapse border-black">
                            <td class="text-center">{{ $loop->iteration + 1 }}</td>
                            <td class="border border-collapse border-black pl-1">{{ $pemasukan->nama }}</td>
                            <td class="border border-collapse border-black pl-1">
                                {{ rupiah($pemasukan->pemasukan->sum('jumlah')) }}
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    <tr class="bg-slate-200 font-bold text-md">
                        <td class="pl-3" colspan="2">
                            Total
                        </td>
                        <td class="pl-1">
                            {{ rupiah($totalPemasukan) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <div class="mt-3 mb-2 font-bold text-lg text-center">Pengeluaran</div>
            <table class="w-full border border-collapse border-black">
                <thead>
                    <tr class="border border-collapse border-black">
                        <th class="border border-collapse border-black">No.</th>
                        <th class="border border-collapse border-black">Kategori Pengeluaran</th>
                        <th class="border border-collapse border-black">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($listPengeluaran as $pengeluaran)
                        <tr class="border border-collapse border-black">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="border border-collapse border-black pl-1">{{ $pengeluaran->nama }}</td>
                            <td class="border border-collapse border-black pl-1">
                                {{ rupiah($pengeluaran->pengeluaran->sum('jumlah')) }}
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    <tr class="bg-slate-200 font-bold text-md">
                        <td class="pl-3" colspan="2">
                            Total
                        </td>
                        <td class="pl-1">
                            {{ rupiah($totalPengeluaran) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

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
