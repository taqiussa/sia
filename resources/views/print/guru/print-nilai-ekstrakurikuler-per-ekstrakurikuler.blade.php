@extends('print')
@section('title', 'Print Nilai Ekstrakurikuler -')
@section('content')
    <div class="text-center font-bold text-md mb-2 capitalize">
        rekap nilai ekstrakurikuler
    </div>
    <div class="flex justify-between font-bold capitalize">
        <div class="flex flex-col">
            <div class="grid grid-cols-2 gap-2">
                <div>ekstrakurikuler</div>
                <div>: {{ $namaEkstra }}</div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>kelompok</div>
                <div>:
                    @switch($jenisKelamin)
                        @case('L')
                            Putra
                        @break

                        @default
                            Putri
                    @endswitch
                </div>
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
    <table class="w-full border border-collapse border-black">
        <thead>
            <tr>
                <th class="border border-collapse border-black w-16">No</th>
                <th class="border border-collapse border-black">Nama</th>
                <th class="border border-collapse border-black">Kelas</th>
                <th class="border border-collapse border-black">Nilai</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listSiswa as $siswa)
                <tr>
                    <td class="text-center border border-collapse border-black">{{ $loop->iteration }}</td>
                    <td class="pl-2 border border-collapse border-black">{{ $siswa->user->name }}</td>
                    <td class="pl-2 border border-collapse border-black">{{ $siswa->kelas->nama }}</td>
                    <td class="pl-2 border border-collapse border-black text-center">{{ $siswa->penilaian->nilai }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex justify-end pt-5">
        <div class="flex flex-col items-center">
            <div>Ngampel, {{ tanggal(date('Y-m-d')) }}</div>
            <div>Pembina Ekstrakurikuler</div>
            <div class="pt-10 font-bold">
                {{ auth()->user()->name }}
            </div>
        </div>
    </div>
@endsection
