@extends('print-no-header')
@section('title', 'Print Daftar Nilai')
@section('content')
    <div class="font-bold text-center text-md capitalize mb-2 border-b-2 border-black">daftar kumpulan nilai
        {{ $namaMapel }}</div>
    <div class="flex justify-between px-1 font-semibold capitalize">
        <div class="flex flex-col justify-center">
            <div class="grid grid-cols-2 gap-2">
                <div>kelas</div>
                <div>: {{ $namaKelas }}</div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>semester</div>
                <div>: {{ $semester }}</div>
            </div>
        </div>
        <div class="flex flex-col justify-center">
            <div class="grid grid-cols-2 gap-2">
                <div>tahun</div>
                <div>: {{ $tahun }}</div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div>wali kelas</div>
                <div>: {{ $namaWaliKelas }}</div>
            </div>
        </div>
    </div>
    <table class="w-full pt-3">
        <thead>
            <tr>
                <th class="border border-collapse border-black">No</th>
                <th class="border border-collapse border-black">NIS</th>
                <th class="border border-collapse border-black">Nama</th>
                @foreach ($listJenis as $jenis)
                    <th class="border border-collapse border-black">{{ $jenis->nama }}</th>
                @endforeach
                <th class="border border-collapse border-black">Nilai Rapor</th>
            </tr>
        </thead>
    </table>
@endsection
