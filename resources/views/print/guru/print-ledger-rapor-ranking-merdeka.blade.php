@extends('print-no-header-rata')
@section('title', 'Print Ledger Rapor Ranking')
@section('content')
    <div class="font-bold text-center text-sm capitalize mb-2 border-b-2 border-black">Ledger Ranking Kelas</div>
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
                <th class="border border-collapse border-black" rowspan="3">Ranking</th>
                <th class="border border-collapse border-black" rowspan="3">NIS</th>
                <th class="border border-collapse border-black" rowspan="3">Nama</th>
                <th class="border border-collapse border-black" colspan="{{ $totalMapel }}">Mata Pelajaran dan KKM</th>
                <th class="border border-collapse border-black" rowspan="3">Total Nilai</th>
            </tr>
            <tr>
                @foreach ($listMapel as $mapel)
                    <th class="border border-collapse border-black">{{ $mapel->mapel->nama }}</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($listMapel as $mapel)
                    <th class="border border-collapse border-black">{{ $mapel->mapel->kkm->kkm }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php
                $siswaRankings = $listSiswa
                    ->map(function ($siswa) use ($listJenis) {
                        $sumAvg = floor(
                            $siswa->penilaians
                                ->where('kategori_nilai_id', 6)
                                ->groupBy('mata_pelajaran_id')
                                ->map(function ($group, $key) {
                                    $avg = $group->avg('nilai');
                                    $floorAvg = floor($avg);
                                    return [
                                        'mata_pelajaran_id' => $key,
                                        'avg' => $avg,
                                        'floor_avg' => $floorAvg,
                                    ];
                                })
                                ->sum('avg'),
                        );
                        return [
                            'siswa' => $siswa,
                            'sum_avg' => $sumAvg,
                        ];
                    })
                    ->sortByDesc('sum_avg')
                    ->values();
            @endphp

            @foreach ($siswaRankings as $rank => $siswaRank)
                @php
                    $siswa = $siswaRank['siswa'];
                    $sumAvg = $siswaRank['sum_avg'];
                @endphp
                <tr>
                    <td class="border border-collapse border-black text-center px-1">{{ $rank + 1 }}</td>
                    <td class="border border-collapse border-black text-center px-1">{{ $siswa->nis }}</td>
                    <td class="border border-collapse border-black px-2 whitespace-nowrap">{{ $siswa->user?->name }}</td>

                    @foreach ($listMapel as $mapel)
                        @php
                            $avg = floor(
                                $siswa->penilaians
                                    ->where('mata_pelajaran_id', $mapel->mata_pelajaran_id)
                                    ->where('kategori_nilai_id', 6)
                                    ->avg('nilai'),
                            );
                        @endphp
                        <td
                            class="border border-collapse border-black text-center px-1 {{ $avg < $mapel->mapel->kkm->kkm ? 'text-red-600 bg-yellow-400' : '' }}">
                            {{ $avg }}
                        </td>
                    @endforeach

                    <td class="border border-collapse border-black text-center px-1">
                        {{ $sumAvg }}
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
