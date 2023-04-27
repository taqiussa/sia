@extends('print')
@section('title', 'Print Nilai Ekstrakurikuler -')
@section('content')
    <div class="text-center font-bold text-md mb-2 capitalize">
        rekap nilai ekstrakurikuler
    </div>
    <div class="flex justify-between font-bold capitalize text-sm">
        <div class="flex flex-col">
            <div class="grid grid-cols-2 gap-2">
                <div>kelas</div>
                <div>: {{ $namaKelas }}</div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>wali kelas</div>
                <div>: {{ $namaWaliKelas }}</div>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="grid grid-cols-2 gap-2">
                <div>tahun</div>
                <div>: {{ $tahun }}</div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>semester</div>
                <div>: {{ $semester }}</div>
            </div>
        </div>
    </div>
    <table class="w-full border border-collapse border-black text-xs">
        <thead>
            <tr>
                <th class="border border-collapse border-black w-16">No</th>
                <th class="border border-collapse border-black">Nama</th>
                <th class="border border-collapse border-black">Ekstrakurikuler</th>
                <th class="border border-collapse border-black">Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listSiswa as $siswa)
                <tr>
                    <td class="text-center border border-collapse border-black">{{ $loop->iteration }}</td>
                    <td class="pl-2 border border-collapse border-black">{{ $siswa->user->name }}</td>
                    <td class="pl-2 border border-collapse border-black">
                        {{ $siswa->penilaianEkstrakurikuler->ekstrakurikuler->nama }}</td>
                    <td class="pl-2 border border-collapse border-black text-center">{{ $siswa->penilaianEkstrakurikuler->nilai }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex justify-end pt-5">
        <div class="flex flex-col items-center">
            <div>Ngampel, {{ tanggal(date('Y-m-d')) }}</div>
            <div>Wali Kelas</div>
            <div class="pt-10 font-bold">
                {{ $namaWaliKelas }}
            </div>
        </div>
    </div>
@endsection
