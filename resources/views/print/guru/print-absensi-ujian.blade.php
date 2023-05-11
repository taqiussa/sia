@extends('print')
@section('title', 'Print Abensi Ujian -')
@section('content')
    <div class="text-center font-bold text-md mb-2 capitalize">
        rekap absensi {{ $namaUjian }} semester {{ $semester }} <br>
        tahun {{ $tahun }}
    </div>
    <div>Hari / Tanggal : {{ hariTanggal($tanggal) }}</div>
    <div>Mata Pelajaran : {{ $namaMapel }}</div>
    <div class="capitalize">Shift :
        @switch($jenisKelamin)
            @case('L')
                Putra
            @break

            @case('P')
                Putri
            @break

            @default
                Putra dan Putri
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
                            @foreach ($listRuang->where('kelas_id', $kelas->id)->unique('nama_ruang')->sortBy('nama_ruang') as $item)
                                <li>
                                    Ruang {{ $item->nama_ruang }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td class="pl-2 border border-collapse border-black align-middle">
                        <ol class=" list-decimal">
                            @foreach ($kelas->absensis->where('kehadiran_id', '!=', 1) as $absen)
                                <li class=" list-inside">
                                    {{ $absen->siswa->name }} ({{ $absen->kehadiran->nama }})
                                </li>
                            @endforeach
                        </ol class=" list-decimal">
                        @foreach ($listRuang->where('kelas_id', $kelas->id)->groupBy('nama_ruang') as $item)
                            @if ($kelas->absensis->whereIn('nis', $item->pluck('nis'))->count() == 0)
                                <li class=" list-none">
                                    Ruang {{ $item->value('nama_ruang') }} Belum di Absen
                                </li>
                            @elseif ($kelas->absensis->whereIn('nis', $item->pluck('nis'))->count() < $item->count())
                                <li class=" list-none">
                                    Ruang {{ $item->value('nama_ruang') }} Absensi Belum Selesai
                                </li>
                            @endif
                        @endforeach
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
