@extends('print')
@section('title', 'Print Nilai Binnadzor -')
@section('content')
    <div class="text-center capitalize font-bold text-md">
        laporan penilaian al qur'an binnadzor tahun {{ $tahun }}
    </div>
    <div class="pt-2 flex justify-between capitalize">
        <div class="grid grid-cols-2 gap-2">
            <div>kelas</div>
            <div>: {{ $namaKelas }}</div>
        </div>
        <div class="grid grid-cols-2 gap-2">
            <div>wali kelas</div>
            <div>: {{ $namaWaliKelas }}</div>
        </div>
    </div>
    <table class="w-full text-xs">
        <thead>
            <tr class="capitalize">
                <th class="border border-collapse border-black w-[2%]">no</th>
                <th class="border border-collapse border-black">nama</th>
                @foreach ($listJenis as $jenis)
                    <th class="border border-collapse border-black w-[1.5%] px-1">
                        {{ $jenis->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($listSiswa as $siswa)
                <tr>
                    <td class="text-center border border-collapse border-black">{{ $loop->iteration }}</td>
                    <td class="pl-2 border border-collapse border-black whitespace-nowrap">{{ $siswa->user->name }}</td>
                    @foreach ($listJenis as $jenis)
                        <td class="text-center border border-collapse border-black uppercase">
                            @foreach ($siswa->penilaianAlqurans as $nilai)
                                @if ($nilai->jenis_alquran_id == $jenis->id)
                                    {{ $nilai->nilai }}
                                @endif
                            @endforeach
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="py-2 px-2 flex justify-between capitalize text-sm">
        <div class="flex flex-col text-center">
            <div>mengetahui,</div>
            <div>kepala sekolah</div>
            <div class="pt-7 font-bold">
                {{ $kepalaSekolah }}
            </div>
        </div>
        <div class="flex flex-col text-center">
            <div>&nbsp;</div>
            <div>guru alquran 1</div>
            <div class="pt-7 font-bold">
                @foreach ($namaGuru->take(1) as $guru)
                    {{ $guru->user->name }}
                @endforeach
            </div>
        </div>
        <div class="flex flex-col text-center">
            <div>ngampel, {{ tanggal(date('Y-m-d')) }}</div>
            <div>guru alquran 2</div>
            <div class="pt-7 font-bold">
                @foreach ($namaGuru->skip(1) as $guru)
                    {{ $guru->user->name }}
                @endforeach
            </div>
        </div>
    </div>
@endsection
