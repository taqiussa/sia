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

        <div class="[page-break-before:always]"></div>

        <div class="flex justify-between border-b-2 border-black pb-2 pt-5">
            <div class="flex flex-col">
                <img src="{{ asset('images/logoalfahp.png') }}" alt="logohp" class="h-20">
            </div>
            <div class="font-bold text-md flex flex-col justify-center uppercase text-center">
                <div>program pengayaan</div>
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
                    <div>wali kelas</div>
                    <div>: {{ $namaWaliKelas }}</div>
                </div>
            </div>
        </div>

        <table class="w-full text-sm capitalize mt-5">
            <tbody>
                <tr>
                    <td>sekolah</td>
                    <td>: SMP al musyaffa</td>
                    <td>penilaian harian</td>
                    <td>: {{ $jenisPenilaian }}</td>
                </tr>
                <tr>
                    <td>kelas / semester</td>
                    <td>: {{ $namaKelas }} / {{ $semester }}</td>
                    <td>tanggal</td>
                    <td>: {{ tanggal($pengayaan->tanggal) }}</td>
                </tr>
                <tr>
                    <td>mata pelajaran / KBM</td>
                    <td>: {{ $namaMapel }} / {{ $kkm }}</td>
                    <td>bentuk pelaksanaan</td>
                    <td>: {{ $pengayaan->bentuk_pelaksanaan }}</td>
                </tr>
                <tr>
                    <td class="py-2">kompetensi inti</td>
                    <td class="py-2 border-b border-black" colspan="3">: {{ $pengayaan->ki }}</td>
                </tr>
                <tr>
                    <td class="py-2">kompetensi dasar</td>
                    <td class="py-2 border-b border-black" colspan="3">: {{ $pengayaan->kd }}</td>
                </tr>
                <tr>
                    <td class="py-2">indikator</td>
                    <td class="py-2 border-b border-black" colspan="3">: {{ $pengayaan->indikator }}</td>
                </tr>
            </tbody>
        </table>
        <div class="font-bold my-5 capitalize">program pengayaan</div>
        <table class="w-full text-xs">
            <thead>
                <tr>
                    <th class="border border-collapse border-black">No</th>
                    <th class="border border-collapse border-black">Nama</th>
                    <th class="border border-collapse border-black">Nilai {{ $jenisPenilaian }}</th>
                    <th class="border border-collapse border-black">Bentuk Pelaksanaan</th>
                    <th class="border border-collapse border-black">Banyak Soal</th>
                    <th class="border border-collapse border-black">Nilai Pengayaan</th>
                    <th class="border border-collapse border-black">Tanda Tangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengayaan->detail->sortBy('user.name')->values() as $siswa)
                    <tr>
                        <td class="px-2 py-1 border border-collapse border-black text-center">{{ $loop->iteration }}</td>
                        <td class="px-2 py-1 border border-collapse border-black">{{ $siswa->user->name }}</td>
                        <td class="px-2 py-1 border border-collapse border-black text-center">{{ $siswa->nilai_awal }}</td>
                        <td class="px-2 py-1 border border-collapse border-black">{{ $pengayaan->bentuk_pelaksanaan }}</td>
                        <td class="px-2 py-1 border border-collapse border-black">{{ $pengayaan->banyak_soal }}</td>
                        <td class="px-2 py-1 border border-collapse border-black text-center">{{ $siswa->nilai_pengayaan }}
                        </td>
                        <td class="px-2 py-1 border border-collapse border-black text-center"></td>
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
                <div>Ngampel, {{ tanggal($pengayaan->tanggal) }}</div>
                <div>Guru Mata Pelajaran</div>
                <div class="font-bold pt-16">{{ auth()->user()->name }}</div>
            </div>
        </div>
    </div>
@endsection
