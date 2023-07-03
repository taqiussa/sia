@extends('print-no-header-rata')
@section('title', 'Print Ledger Sikap')
@section('content')
    <div class="font-bold text-center text-sm capitalize mb-2 border-b-2 border-black">Ledger Hasil Penilaian Sikap</div>
    <div class="flex justify-between px-1 font-semibold capitalize text-xs">
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
    <table class="w-full pt-3 text-[9px]">
        <thead>
            <tr>
                <th class="border border-collapse border-black" rowspan="2">No</th>
                <th class="border border-collapse border-black" rowspan="2">NIS</th>
                <th class="border border-collapse border-black" rowspan="2">Nama</th>
                <th class="border border-collapse border-black" colspan="{{ $totalMapel }}">Mata Pelajaran</th>
                <th class="border border-collapse border-black" rowspan="2">Total Nilai</th>
            </tr>
            <tr>
                @foreach ($listMapel as $mapel)
                    <th class="border border-collapse border-black">{{ $mapel->mapel->nama }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($listSiswa as $siswa)
                <tr>
                    <td class="border border-collapse border-black text-center px-1">{{ $loop->iteration }}</td>
                    <td class="border border-collapse border-black text-center px-1">{{ $siswa->nis }}</td>
                    <td class="border border-collapse border-black px-2 whitespace-nowrap">{{ $siswa->user?->name }}</td>

                    @foreach ($listMapel as $mapel)
                        @php
                            $avg = floor(
                                $siswa->penilaianSikaps
                                    ->where('mata_pelajaran_id', $mapel->mata_pelajaran_id)
                                    // ->where('kategori_sikap_id', 3)
                                    ->avg('nilai'),
                            );
                        @endphp
                        <td
                            class="border border-collapse border-black text-center px-1">
                            {{ $avg }}
                        </td>
                    @endforeach

                    <td class="border border-collapse border-black text-center px-1">
                        {{ floor(
                            $siswa->penilaianSikaps->groupBy('mata_pelajaran_id')->map(function ($group, $key) {
                                    $avg = $group->avg('nilai');
                                    $floorAvg = floor($avg);
                                    return [
                                        'mata_pelajaran_id' => $key,
                                        'avg' => $avg,
                                        'floor_avg' => $floorAvg,
                                    ];
                                })->sum('avg'),
                        ) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex justify-end items-start text-xs pt-3 px-10">
        <div class="flex flex-col items-center justify-center">
            <div class="font-semibold">Ngampel, {{ tanggal(date('Y-m-d')) }}</div>
            <div class="font-semibold">Wali Kelas</div>
            <div class="font-bold pt-16">{{ $namaWaliKelas }}</div>
        </div>
    </div>
@endsection
