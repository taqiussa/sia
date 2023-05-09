@extends('print')
@section('title', 'Print Abensi Ujian -')
@section('content')
    <div class="text-center font-bold text-md mb-2 capitalize">
        rekap absensi {{ $namaUjian }} semester {{ $semester }} <br>
        tahun {{ $tahun }}
    </div>
    <div>Hari / Tanggal : {{ hariTanggal($tanggal) }}</div>
    <div>Shift :
        @switch($jenisKelamin)
            @case('L')
                Putra
            @break

            @default
                Putri
        @endswitch
    </div>
    <div>
        Jam : {{ $jam }}
    </div>
    <table class="w-full border border-collapse border-black">
        <thead>
            <tr>
                <th class="border border-collapse border-black w-16">No</th>
                <th class="border border-collapse border-black">Kelas</th>
                <th class="border border-collapse border-black">Keterangan</th>
                <th class="border border-collapse border-black">Kehadiran</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listKelas as $kelas)
                <tr>
                    <td class="text-center border border-collapse border-black align-middle">{{ $loop->iteration }}</td>
                    <td class="pl-2 border border-collapse border-black align-middle text-center">{{ $kelas->nama }}</td>
                    <td class="pl-2 border border-collapse border-black">
                        <ul>
                            @foreach ($kelas->ruangUjian->unique('nama_ruang')->sortBy('nama_ruang') as $item)
                                <li>
                                    Ruang {{ $item->nama_ruang }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="pl-2 border border-collapse border-black align-middle">
                        <ol class=" list-decimal">
                            @foreach ($kelas->absensis as $absen)
                                <li class=" list-inside">
                                    {{ $absen->siswa->name }} ({{ $absen->kehadiran->nama }})
                                </li>
                            @endforeach
                        </ol class=" list-decimal">
                        @forelse ($kelas->absensis as $absensi)
                            @if ($kelas->total_absensi < $kelas->total_siswa)
                                Absensi Belum Selesai
                            @endif
                        @empty
                            @if (empty($kelas->total_absensi))
                                Belum Ada Absensi
                            @elseif ($kelas->total_absensi < $kelas->total_siswa)
                                Absensi Belum Selesai
                            @else
                                Nihil
                            @endif
                        @endforelse
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex justify-end pt-5">
        <div class="flex flex-col items-center">
            <div>Ngampel, {{ tanggal($tanggal) }}</div>
            <div>Pengawas Kehadiran</div>
            <div class="pt-10">
                {{ auth()->user()->name }}
            </div>
        </div>
    </div>
@endsection
