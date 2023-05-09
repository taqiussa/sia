@extends('print')
@section('title', 'Rekap Per Siswa')
@section('content')
    <div class="text-center font-bold text-md mb-2 capitalize">
        rekap pembayaran siswa tahun pelajaran {{ $tahun }}
    </div>
    <div class="grid grid-cols-7 capitalize">
        <div>
            nama
        </div>
        <div class="col-span-6 capitalize">
            : {{ $siswa->user->name }}
        </div>
    </div>
    <div class="grid grid-cols-7 capitalize">
        <div>
            kelas
        </div>
        <div class="col-span-6 capitalize">
            : {{ $siswa->kelas->nama }}
        </div>
    </div>
    <table class="w-full border border-collapse border-black py-5">
        <thead>
            <tr class="border border-collapse border-black">
                <th>No.</th>
                <th class="border border-collapse border-black pl-2">Pembayaran</th>
                <th class="border border-collapse border-black pl-2">Tanggal Bayar</th>
                <th class="border border-collapse border-black pl-2">Jumlah</th>
                <th class="border border-collapse border-black pl-2">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listGunabayar as $gunabayar)
                <tr class="border border-collapse border-black">
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="border border-collapse border-black pl-2">{{ $gunabayar->nama }}</td>
                    <td class="border border-collapse border-black pl-2">
                        @foreach ($siswa->pembayarans as $pembayaran)
                            {{ $pembayaran->gunabayar_id == $gunabayar->id ? hariTanggal($pembayaran->tanggal) : null }}
                        @endforeach
                    </td>
                    <td class="border border-collapse border-black pl-2">
                        @foreach ($siswa->pembayarans as $pembayaran)
                            {{ $pembayaran->gunabayar_id == $gunabayar->id ? rupiah($pembayaran->jumlah) : null }}
                        @endforeach
                    </td>
                    <td class="border border-collapse border-black pl-2">
                        @foreach ($siswa->pembayarans as $pembayaran)
                            {{ $pembayaran->gunabayar_id == $gunabayar->id ? 'Lunas' : null }}
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex justify-between pl-7 pr-3 py-3">
        <div>
            <div class="font-bold text-slate-600 grid grid-cols-4 capitalize">
                <div>
                    keterangan
                </div>
                <div class="font-bold text-slate-600 col-span-2 capitalize">
                    &nbsp;
                </div>
            </div>
            <div class="font-bold text-slate-600 grid grid-cols-4 capitalize">
                <div>
                    wajib bayar
                </div>
                <div class="font-bold text-slate-600 col-span-2 capitalize">
                    : {{ rupiah($wajibBayar) }}
                </div>
            </div>
            <div class="font-bold text-slate-600 grid grid-cols-4 capitalize">
                <div>
                    total bayar
                </div>
                <div class="font-bold text-slate-600 col-span-2 capitalize">
                    : {{ rupiah($siswa->pembayarans->sum('jumlah')) }}
                </div>
            </div>
            <div class="font-bold text-slate-600 grid grid-cols-4 capitalize">
                <div>
                    kurang bayar
                </div>
                <div class="font-bold col-span-2 capitalize">
                    : {{ rupiah($wajibBayar - $siswa->pembayarans->sum('jumlah')) }}
                </div>
            </div>
        </div>


        <div class="flex flex-col text-center">
            <div>
                Ngampel, {{ tanggal(date('Y-m-d')) }}
            </div>
            <div>Bendahara</div>
            <div class="pt-16 font-bold">{{ $namaBendahara->skip(1)->first()->name }}</div>
        </div>
    </div>
@endsection
