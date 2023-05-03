@extends('print-no-header')
@section('title', 'Print Pencapaian Kompetensi')
@section('content')
    <div class="flex justify-between border-b-2 border-black pb-2">
        <div class="flex flex-col">
            <img src="{{ asset('images/logoalfahp.png') }}" alt="logohp" class="h-20">
        </div>
        <div class="font-bold text-md flex flex-col justify-center uppercase text-center">
            <div>analisis pencapaian kompetensi</div>
            <div>smp al musyaffa kendal</div>
        </div>
        <div class="font-bold text-xs flex flex-col justify-center capitalize w-[280px]">
            <div class="grid grid-cols-2">
                <div>kelas</div>
                <div>: {{ $namaKelas }}</div>
            </div>
            <div class="grid grid-cols-2">
                <div>semester</div>
                <div>: {{ $semester }}</div>
            </div>
            <div class="grid grid-cols-2">
                <div>mata pelajaran</div>
                <div>: {{ $namaMapel }}</div>
            </div>
            <div class="grid grid-cols-2">
                <div>KI 3</div>
                <div>: {{ $namaKategori }}</div>
            </div>
            <div class="grid grid-cols-2">
                <div>wali kelas</div>
                <div>: {{ $namaWaliKelas }}</div>
            </div>
        </div>
    </div>
    <table class="w-full text-xs mt-3">
        <thead>
            <tr>
                <th class="border border-collapse border-black">No</th>
                <th class="border border-collapse border-black">NIS</th>
                <th class="border border-collapse border-black">Nama</th>
                @foreach ($listJenis as $jenis)
                    <th class="border border-collapse border-black">{{ $jenis->nama }}</th>
                @endforeach
                <th class="border border-collapse border-black">Rata-rata</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listSiswa as $siswa)
                <tr>
                    <td class="border border-collapse border-black text-center px-1">{{ $loop->iteration }}</td>
                    <td class="border border-collapse border-black text-center px-1">{{ $siswa->nis }}</td>
                    <td class="border border-collapse border-black px-2">{{ $siswa->user?->name }}</td>
                    @foreach ($listJenis as $jenis)
                        <td class="border border-collapse border-black text-center px-1">
                            @foreach ($siswa->penilaians as $nilai)
                                @if ($nilai->jenis_penilaian_id == $jenis->id)
                                    {{ $nilai->nilai }}
                                @endif
                            @endforeach

                        </td>
                    @endforeach
                    <td class="border border-collapse border-black text-center px-1">
                        {{ floor($siswa->penilaians->avg('nilai')) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex justify-between items-start text-xs pt-3 px-10">
        <div class="flex flex-col items-center justify-center">
            <div>Mengetahui</div>
            <div>Kepala Sekolah</div>
            <div>
                <img src="{{ asset('images/kasek.png') }}" alt="ttd" class="h-16">
            </div>
            <div class="font-bold">{{ $namaKepalaSekolah }}</div>
        </div>
        <div class="flex flex-col items-center justify-center">
            <div>Ngampel, {{ tanggal($listSiswa->first()->analisisPenilaian->tanggal) }}</div>
            <div>Guru Mata Pelajaran</div>
            <div class="font-bold pt-16">{{ auth()->user()->name }}</div>
        </div>
    </div>
@endsection
