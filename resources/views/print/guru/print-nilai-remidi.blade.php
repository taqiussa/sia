@extends('print')
@section('title', 'Print Nilai Remidi')
@section('content')
    <div class="pl-14 pr-5">
        <div class="text-center text-xl font-bold tracking-widest capitalize mb-2">bentuk pelaksanaan remidial</div>
        <ol class="list-decimal space-y-2">
            <li class="font-bold text-md">Cara yang ditempuh</li>
            <ol class="tracking-widest text-md list-outisde pl-5">
                <li class="list-item list-alpha"> Pemberian bimbingan secara khusus dan perorangan bagi peserta didik yang
                    belum atau mengalami kesulitan
                    dalam penguasaan
                    @if ($namaKurikulum == 'K13')
                        KD
                    @else
                        tujuan pembelajaran
                    @endif

                    tertentu
                </li>
                <li class="list-item list-alpha"> Pemberian tugas - tugas atau perlakuan secara khusus, yang sifatnya
                    penyederhanaan dari pelaksanaan
                    pembelajaran regular
                </li>
            </ol>
            <li class="font-bold text-md">Bentuk penyederhanaan itu dapat dilakukan guru antara lain melalui :</li>
            <ol class="tracking-widest text-md list-outside pl-5">
                <li class="list-item list-alpha"> Penyederhanaan strategi pembelajaran untuk
                    @if ($namaKurikulum == 'K13')
                        KD
                    @else
                        tujuan pembelajaran
                    @endif

                    tertentu
                </li>
                <li class="list-item list-alpha"> Penyederhanaan cara penyajian (misalnya menggunakan gambar, model, skema,
                    video pembelajaran,
                    memberikan rangkuman sederhana, dll)</li>
                <li class="list-item list-alpha">
                    Penyederhanaan soal atau pertanyaan yang diberikan
                </li>
            </ol>
            <li class="font-bold text-md">Materi dan waktu pelaksanaan program remidial</li>
            <ol class="tracking-widest text-md list-outisde pl-5">
                <li class="list-item list-alpha">
                    Program remidial diberikan hanya pada
                    @if ($namaKurikulum == 'K13')
                        KD atau indikator yang belum tuntas
                    @else
                        tujuan pembelajaran atau indikator yang belum tercapai
                    @endif
                </li>
                <li class="list-item list-alpha">
                    Program remidial dilaksanakan setelah mengikuti tes /
                    @if ($namaKurikulum == 'K13')
                        ulangan KD tertentu atau sejumlah KD dalam satu
                        kesatuan
                    @else
                        asesmen sumatif akhir materi tertentu atau sejumlah tujuan pembelajaran dalam satu
                        kesatuan
                    @endif
                </li>
            </ol>
            <li class="font-bold text-md">Teknik pelaksanaan penugasan / pembelajaran remidial</li>
            <ol class="tracking-widest text-md list-outisde pl-5">
                @if ($namaKurikulum == 'K13')
                    <li class="list-item list-alpha"> Penugasan individu diakhiri dengan tes (lisan / tertulis) bila jumlah
                        peserta didik yang mengikuti
                        remidial maksiaml 20% dari jumlah siswa per kelas</li>
                    <li class="list-item list-alpha"> Penugasan kelompok diakhiri dengan tes individual (lisan / tertulis)
                        bila jumlah peserta didik yang
                        mengikuti remidi lebih dari 20% tetapi kurang dari 50%</li>
                    <li class="list-item list-alpha"> Pembelajaran ulang diakhiri dengan tes tertulis bila jumlah siswa yang
                        mengikuti remidi lebih dari
                        50%
                    </li>
                @else
                    <li class="list-item list-alpha"> Penugasan individu diakhiri dengan tes (lisan / tertulis) dengan
                        mengerjakan kembali butir soal
                        asesmen sumatif akhir materi berdasarkan tujuan pembelajaran atau indikator yang belum tercapai oleh
                        masing masing peserta didik</li>
                @endif
            </ol>
        </ol>

        <div class="[page-break-before:always]"></div>

        <div class="flex justify-between border-b-2 border-black pb-2 pt-5">
            <div class="flex flex-col">
                <img src="{{ asset('images/logoalfahp.png') }}" alt="logohp" class="h-20">
            </div>
            <div class="font-bold text-md flex flex-col justify-center uppercase text-center">
                <div>program remedial</div>
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
                    <td>tahun pelajaran</td>
                    <td>: {{ $remidi->tahun }}</td>
                </tr>
                <tr>
                    <td>mata pelajaran / KBM</td>
                    <td>: {{ $namaMapel }} / {{ $kkm }}</td>
                    <td>tanggal</td>
                    <td>: {{ tanggal($remidi->tanggal) }}</td>
                </tr>
                <tr>
                    <td class="py-2">kompetensi inti</td>
                    <td class="py-2 border-b border-black" colspan="3">: {{ $remidi->ki }}</td>
                </tr>
                <tr>
                    <td class="py-2">materi</td>
                    <td class="py-2 border-b border-black" colspan="3">: {{ $remidi->materi }}</td>
                </tr>
            </tbody>
        </table>
        <div class="font-bold my-5 capitalize">program remedial</div>
        <table class="w-full text-xs">
            <thead>
                <tr>
                    <th class="border border-collapse border-black">No</th>
                    <th class="border border-collapse border-black">Nama</th>
                    <th class="border border-collapse border-black">Nilai {{ $jenisPenilaian }}</th>
                    <th class="border border-collapse border-black">Nilai Remedial</th>
                    <th class="border border-collapse border-black">Nilai Akhir</th>
                    <th class="border border-collapse border-black">Tanda Tangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($remidi->detail->sortBy('user.name')->values() as $siswa)
                    <tr>
                        <td class="px-2 py-1 border border-collapse border-black text-center">{{ $loop->iteration }}</td>
                        <td class="px-2 py-1 border border-collapse border-black">{{ $siswa->user->name }}</td>
                        <td class="px-2 py-1 border border-collapse border-black text-center">{{ $siswa->nilai_awal }}</td>
                        <td class="px-2 py-1 border border-collapse border-black text-center">{{ $siswa->nilai_remidi }}
                        </td>
                        <td class="px-2 py-1 border border-collapse border-black text-center">{{ $siswa->nilai_akhir }}
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
                <div>Ngampel, {{ tanggal($remidi->tanggal) }}</div>
                <div>Guru Mata Pelajaran</div>
                <div class="font-bold pt-16">{{ auth()->user()->name }}</div>
            </div>
        </div>

        <div class="[page-break-before:always]"></div>
        <div class="pt-7 pb-2">
            @include('header')
        </div>

        <div class="text-center text-sm font-bold tracking-wider uppercase">
            berita acara <br>
            penyelenggaraan program remidial <br>
            smp al musyaffa <br>
            tahun pelajaran {{ $tahun }}
        </div>

        <div class="font-bold pt-3 text-sm capitalize">mata pelajaran : {{ $namaMapel }}</div>

        <div class="text-sm pt-2 capitalize">pada {{ hariTanggal($remidi->tanggal) }}</div>

        <ol class="text-sm list-outisde pl-5">
            <li class="list-item list-alpha">
                Telah di selenggarakan program remidial dari jam .................... s/d ...................
            </li>
            <table class="w-full">
                <tbody>
                    <tr>
                        <td class="py-1">Nama Sekolah</td>
                        <td class="py-1 border-b border-black">: SMP Al Musyaffa</td>
                    </tr>
                    <tr>
                        <td class="py-1">Kelas / Semester</td>
                        <td class="py-1 border-b border-black">: {{ $namaKelas }} / {{ $semester }}</td>
                    </tr>
                    <tr>
                        <td class="py-1">Jumlah peserta seharusnya</td>
                        <td class="py-1 border-b border-black">: </td>
                    </tr>
                    <tr>
                        <td class="py-1">Yang hadir</td>
                        <td class="py-1 border-b border-black">: </td>
                    </tr>
                    <tr>
                        <td class="py-1">Yang tidak hadir</td>
                        <td class="py-1 border-b border-black">: </td>
                    </tr>
                </tbody>
            </table>
            <li class="list-item list-alpha">
                catatan selama remidial
            </li>
            <table class="w-full">
                <tbody>
                    <tr>
                        <td class="py-1 border-b border-black">{{ $remidi->catatan }}</td>
                    </tr>
                    <tr>
                        <td class="py-1 border-b border-black">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="py-1 border-b border-black">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        </ol>

        <div class="text-sm pt-5">Demikian berita acara ini dibuat dengan sebenarnya</div>

        <div class="flex justify-between items-start text-sm pt-3 px-10">
            <div class="flex flex-col items-center justify-center">
                <div>Mengetahui</div>
                <div>Kepala Sekolah</div>
                <div>
                    <img src="{{ asset('images/kasek.png') }}" alt="ttd" class="h-16">
                </div>
                <div class="font-bold">{{ $namaKepalaSekolah }}</div>
            </div>
            <div class="flex flex-col items-center justify-center">
                <div>Ngampel, {{ tanggal($remidi->tanggal) }}</div>
                <div>Guru Mata Pelajaran</div>
                <div class="font-bold pt-16">{{ auth()->user()->name }}</div>
            </div>
        </div>

    </div>
@endsection
