@extends('print')
@section('title', 'Print Nilai Bilghoib -')
@section('content')
    <div class="text-center capitalize font-bold text-md">
        laporan penilaian al qur'an bilghoib
    </div>
    <div class="flex flex-col capitalize">
        <div class="grid grid-cols-10">
            <div>nama</div>
            <div class="col-span-9">: {{ $siswa->user->name }}</div>
        </div>
        <div class="grid grid-cols-10">
            <div>kelas</div>
            <div class="col-span-9">: {{ $siswa->kelas->nama }}</div>
        </div>
        <div class="grid grid-cols-10">
            <div>tahun</div>
            <div class="col-span-9">: {{ $tahun }}</div>
        </div>
    </div>
    <div class="flex flex-row space-x-10 capitalize">
        <table class="w-full">
            <thead>
                <tr class="border border-collapse border-black">
                    <th class="border border-collapse border-black">no</th>
                    <th class="border border-collapse border-black">surah</th>
                    <th class="border border-collapse border-black">nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listJenis->take(19) as $jenis)
                    <tr class="border border-collapse border-black">
                        <td class="border border-collapse border-black text-center">{{ $loop->iteration }}</td>
                        <td class="border border-collapse border-black pl-2">{{ $jenis->nama }}</td>
                        <td class="border border-collapse border-black text-center">
                            @foreach ($siswa->penilaianAlqurans as $nilai)
                                @if ($nilai->jenis_alquran_id === $jenis->id)
                                    {{ $nilai->nilai }}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table class="w-full">
            <thead>
                <tr class="border border-collapse border-black">
                    <th class="border border-collapse border-black">no</th>
                    <th class="border border-collapse border-black">surah</th>
                    <th class="border border-collapse border-black">nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listJenis->skip(19) as $jenis)
                    <tr class="border border-collapse border-black">
                        <td class="border border-collapse border-black text-center">{{ $loop->iteration }}</td>
                        <td class="border border-collapse border-black pl-2">{{ $jenis->nama }}</td>
                        <td class="border border-collapse border-black text-center">
                            @foreach ($siswa->penilaianAlqurans as $nilai)
                                @if ($nilai->jenis_alquran_id === $jenis->id)
                                    {{ $nilai->nilai }}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex justify-between capitalize py-3 px-7">
        <div class="flex flex-col text-center">
            <div>&nbsp;</div>
            <div>guru al qur'an 1</div>
            <div class="pt-10 font-bold">
                @foreach ($namaGuru->take(1) as $guru)
                    {{ $guru->user->name }}
                @endforeach
            </div>
        </div>
        <div class="flex flex-col text-center">
            <div>ngampel, {{ tanggal(date('Y-m-d')) }}</div>
            <div>guru al qur'an 2</div>
            <div class="pt-10 font-bold">
                @foreach ($namaGuru->skip(1) as $guru)
                    {{ $guru->user->name }}
                @endforeach
            </div>
        </div>
    </div>
@endsection
