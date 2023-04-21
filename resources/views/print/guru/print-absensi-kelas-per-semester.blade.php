@extends('print')
@section('title', 'Print Absensi Per Bulan -')
@section('content')
    <div class="text-center font-bold capitalize">laporan kehadiran siswa <br> tahun {{ $tahun }}</div>
    <div class="w-full capitalize font-bold text-sm">
        <div class="grid grid-cols-6">
            <div>kelas</div>
            <div class="col-span-5">: {{ $namaKelas }}</div>
        </div>
        <div class="grid grid-cols-6">
            <div>semester</div>
            <div class="col-span-5">: {{ $semester }}</div>
        </div>
        <div class="grid grid-cols-6">
            <div>wali kelas</div>
            <div class="col-span-5">: {{ $namaWaliKelas }}</div>
        </div>
    </div>
    <table class="w-full py-3 border border-collapse border-black text-xs">
        <thead>
            <tr class="border border-collapse border-black capitalize">
                <th class="border border-collapse border-black" rowspan="2">no</th>
                <th class="border border-collapse border-black whitespace-nowrap" rowspan="2">nama</th>
                <th class="border border-collapse border-black" colspan="6">kehadiran</th>
                <th class="border border-collapse border-black" rowspan="2">total</th>
                <th class="border border-collapse border-black" rowspan="2">presentase</th>
            </tr>
            <tr class="border border-collapse border-black capitalize">
                <th class="border border-collapse border-black">h</th>
                <th class="border border-collapse border-black">i</th>
                <th class="border border-collapse border-black">s</th>
                <th class="border border-collapse border-black">a</th>
                <th class="border border-collapse border-black">b</th>
                <th class="border border-collapse border-black">p</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listSiswa as $siswa)
                <tr class="border border-collapse border-black capitalize">
                    <td class="border border-collapse border-black capitalize text-center">{{ $loop->iteration }}</td>
                    <td class="border border-collapse border-black capitalize align-middle pl-2">
                        {{ $siswa->user->name }}
                    </td>
                    <td class="border border-collapse border-black capitalize align-middle text-center">
                        {{ $siswa->absensis->where('kehadiran_id', 1)->count() }}
                    </td>
                    <td class="border border-collapse border-black capitalize align-middle text-center">
                        {{ $siswa->absensis->where('kehadiran_id', 3)->count() }}
                    </td>
                    <td class="border border-collapse border-black capitalize align-middle text-center">
                        {{ $siswa->absensis->where('kehadiran_id', 2)->count() }}
                    </td>
                    <td class="border border-collapse border-black capitalize align-middle text-center">
                        {{ $siswa->absensis->where('kehadiran_id', 4)->count() }}
                    </td>
                    <td class="border border-collapse border-black capitalize align-middle text-center">
                        {{ $siswa->absensis->where('kehadiran_id', 5)->count() }}
                    </td>
                    <td class="border border-collapse border-black capitalize align-middle text-center">
                        {{ $siswa->absensis->where('kehadiran_id', 6)->count() }}
                    </td>
                    <td class="border border-collapse border-black capitalize align-middle text-center">
                        {{ $siswa->absensis->count() }}
                    </td>
                    @php
                        $total = round(($siswa->absensis->where('kehadiran_id', 1)->count() / $totalTertinggi) * 100, 2);
                    @endphp
                    @if ($total < 80)
                        <td
                            class="border border-collapse border-black capitalize align-middle text-center text-white font-bold bg-red-600">
                            {{ $total . ' %' }}
                        </td>
                    @else
                        <td class="border border-collapse border-black capitalize align-middle text-center">
                            {{ $total . ' %' }}
                        </td>
                    @endif

                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex justify-end pt-5">
        <div class="flex flex-col items-center text-center">
            <div>Ngampel, {{ tanggal(date('Y-m-d')) }}</div>
            <div>Guru Bimbingan dan Konseling</div>
            <div class="p-7">&nbsp;</div>
            <div class="font-bold">
                {{ $guruBk }}
            </div>
        </div>
    </div>
@endsection
