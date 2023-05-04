@extends('print')
@section('title', 'Print Nilai Pengayaan')
@section('content')
    <div class="pl-14 pr-5">
        <div class="text-center text-xl font-bold tracking-widest capitalize mb-2">pelaksanaan program pengayaan</div>
        <ol class="list-decimal space-y-2">
            <li class="font-bold text-md">Cara yang ditempuh</li>
            <ol class="tracking-widest text-md list-outisde pl-5">
                <li class="list-item list-alpha"> Pemberian bacaan tambahan atau berdiskusi yang bertujuan memperluas wawasan
                    pada
                    @if ($namaKurikulum == 'K13')
                        KD
                    @else
                        Tujuan Pembelajaran
                    @endif
                    tertentu
                </li>
                <li class="list-item list-alpha"> Pemberian tugas untuk melakukan analisis gambar, model, grafik, bacaan,
                    dll.
                </li>
                <li class="list-item list-alpha"> Memberikan soal-soal latihan tambahan yang bersifat pengayaan</li>
                <li class="list-item list-alpha"> Membantu guru dalam membimbing teman-temannya yang belum mencapai
                    @if ($namaKurikulum == 'K13')
                        ketuntasan
                    @else
                        tujuan pembelajaran
                    @endif

                </li>
            </ol>
            <li class="font-bold text-md">Materi dan waktu pelaksanaan program pengayaan</li>
            <ol class="tracking-widest text-md list-outside pl-5">
                <li class="list-item list-alpha"> Materi program pengayaan diberikan sesuai dengan
                    @if ($namaKurikulum == 'K13')
                        KD
                    @else
                        Tujuan Pembelajaran
                    @endif

                    atau indikator yang dipelajari, bisa berupa
                    penguatan materi yang dipelajari maupun berupa pengembangan materi
                </li>
                <li class="list-item list-alpha"> Waktu pelaksanaan program pengayaan adalah :</li>
                <ul>
                    <li>Setelah mengikuti test /
                        @if ($namaKurikulum == 'K13')
                            ulangan KD tertentu
                        @else
                            Asesmen sumatif akhir materi tertentu
                        @endif
                    </li>
                    <li>Pada saat pembelajaran dimana siswa yang lebih cepat tuntas dibanding dengan teman lainnya maka
                        dilayani dengan program pengayaan</li>
                </ul>
            </ol>
        </ol>

        <p class="pt-5 text-justify text-md tracking-wide">
            Sebagai bagian yang integral dari kegiatan pembelajaran, kegiatan pengayaan tidak lepas kaitannya dengan
            @if ($namaKurikulum == 'K13')
                penilaian - penilaian
            @else
                asesmen
            @endif

            hasil belajar. Kegiatan pengayaan tertentu tidak sama dengan kegiatan pembelajaran tapi
            cukup dalam bentuk
            @if ($namaKurikulum == 'K13')
                portofolio, dan harus dihargai dengan nilai tambah (lebih) dari peserta yang remidial.
            @else
                penugasan, dan dihargai dengan nilai tambah (lebih) dari peserta yang remidial.
            @endif
        </p>
    </div>

    {{-- <div class="font-bold text-center text-md capitalize mb-2 border-b-2 border-black">daftar kumpulan nilai
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
    </div> --}}
@endsection
