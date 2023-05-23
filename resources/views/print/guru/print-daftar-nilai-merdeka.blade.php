@extends('print-no-header-rata')
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
    <table class="w-full pt-3 text-xs">
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
                                    <div class="{{ $nilai->nilai < $kkm ? 'text-red-600 bg-yellow-400' : '' }}">
                                        {{ $nilai->nilai }}
                                    </div>
                                @endif
                            @endforeach
                        </td>
                    @endforeach
                    <td
                        class="border border-collapse border-black text-center px-1 {{ floor($siswa->penilaians->where('kategori_nilai_id', 6)->avg('nilai')) < $kkm ? 'text-red-600 bg-yellow-400' : '' }}">
                        {{ floor($siswa->penilaians->where('kategori_nilai_id', 6)->avg('nilai')) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex justify-between items-start text-sm pt-3 px-10">
        <div class="flex flex-col items-center justify-center">
            <div>&nbsp;</div>
            <div class="font-semibold">Wali Kelas</div>
            <div class="font-bold pt-16">{{ $namaWaliKelas }}</div>
        </div>
        <div class="flex flex-col items-center justify-center">
            <div class="font-semibold">Ngampel, {{ tanggal(date('Y-m-d')) }}</div>
            <div class="font-semibold">Guru Mata Pelajaran</div>
            <div class="font-bold pt-16">{{ auth()->user()->name }}</div>
        </div>
    </div>
@endsection
