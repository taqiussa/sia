@extends('print')
@section('title', 'Rekap Per Siswa -')
@section('content')
    <div class="text-center font-bold text-md mb-2 capitalize">
        tagihan administrasi siswa tahun pelajaran {{ $tahun }}
    </div>
    <div class="flex justify-between px-2">
        <div class="grid grid-cols-4 capitalize">
            <div>
                kelas
            </div>
            <div class="col-span-3 capitalize">
                : {{ $namaKelas }}
            </div>
        </div>
        <div class="grid grid-cols-4 capitalize">
            <div>
                wali kelas
            </div>
            <div class="col-span-3 capitalize">
                : {{ $namaWaliKelas }}
            </div>
        </div>
    </div>

    <table class="w-full border border-collapse border-black py-5 text-xs">
        <thead>
            <tr class="border border-collapse border-black">
                <th>No.</th>
                <th class="border border-collapse border-black">Nama</th>
                <th class="border border-collapse border-black">Juli</th>
                <th class="border border-collapse border-black">Agustus</th>
                <th class="border border-collapse border-black">September</th>
                <th class="border border-collapse border-black">Oktober</th>
                <th class="border border-collapse border-black">November</th>
                <th class="border border-collapse border-black">Desember</th>
                <th class="border border-collapse border-black">Januari</th>
                <th class="border border-collapse border-black">Februari</th>
                <th class="border border-collapse border-black">Maret</th>
                <th class="border border-collapse border-black">April</th>
                <th class="border border-collapse border-black">Mei</th>
                <th class="border border-collapse border-black">Juni</th>
                <th class="border border-collapse border-black">Belum Dibayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listSiswa as $siswa)
                <tr class="border border-collapse border-black">
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="border border-collapse border-black px-1 whitespace-nowrap">{{ $siswa->user->name }}</td>
                    @foreach ($listGunabayar as $gunabayar)
                        <td class="border border-collapse border-black px-1 whitespace-nowrap">
                            @foreach ($siswa->pembayarans as $pembayaran)
                                {{ $pembayaran->gunabayar_id == $gunabayar->id ? rupiah($pembayaran->jumlah) : null }}
                            @endforeach
                        </td>
                    @endforeach
                    <td class="border border-collapse border-black px-1 whitespace-nowrap">
                        {{ rupiah($wajibBayar - $siswa->pembayarans->sum('jumlah')) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex justify-end pt-3">
        <div class="flex flex-col text-center">
            <div>
                Ngampel, {{ tanggal(date('Y-m-d')) }}
            </div>
            <div>Bendahara</div>
            <div class="pt-16 font-bold">{{ auth()->user()->name }}</div>
        </div>
    </div>
@endsection
