<div class="flex justify-between">
    <div>
        <img src="{{ asset('images/logoalfahp.png') }}" alt="logohp" class="h-20">
    </div>
    <div class="font-bold text-sm flex flex-col justify-center uppercase text-center">
        <div>rekap analisis penilaian {{ $jenisPenilaian }}</div>
        <div>smp al musyaffa kendal</div>
    </div>
    <div class="font-bold text-sm flex flex-col justify-center capitalize w-[280px]">
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
            <div>tahun</div>
            <div>: {{ $tahun }}</div>
        </div>
    </div>
</div>
<div class="font-bold text-sm capitalize pt-5">i. identitas</div>
<table class="w-full capitalize text-sm">
    <tbody>
        <tr>
            <td class="py-1 px-2 w-2">1</td>
            <td class="py-1 px-2 w-80">mata pelajaran</td>
            <td class="py-1 px-2 w-2">:</td>
            <td class="py-1 px-2 border-b border-collapse border-black">{{ $namaMapel }}</td>
        </tr>
        <tr>
            <td class="py-1 px-2">2</td>
            <td class="py-1 px-2">kelas / semester</td>
            <td class="py-1 px-2">:</td>
            <td class="py-1 px-2 border-b border-collapse border-black">{{ $namaKelas }} / {{ $semester }}</td>
        </tr>
        <tr>
            <td class="py-1 px-2">3</td>
            <td class="py-1 px-2">KI / KD</td>
            <td class="py-1 px-2">:</td>
            <td class="py-1 px-2 border-b border-collapse border-black"></td>
        </tr>
        <tr>
            <td class="py-1 px-2">4</td>
            <td class="py-1 px-2">waktu pelaksanaan</td>
            <td class="py-1 px-2">:</td>
            <td class="py-1 px-2 border-b border-collapse border-black"></td>
        </tr>
        <tr>
            <td class="py-1 px-2">5</td>
            <td class="py-1 px-2">jumlah peserta</td>
            <td class="py-1 px-2">:</td>
            <td class="py-1 px-2 border-b border-collapse border-black"></td>
        </tr>
        <tr>
            <td class="py-1 px-2">6</td>
            <td class="py-1 px-2">jumlah soal</td>
            <td class="py-1 px-2">:</td>
            <td class="py-1 px-2 border-b border-collapse border-black"></td>
        </tr>
        <tr>
            <td class="py-1 px-2">7</td>
            <td class="py-1 px-2">bentuk soal</td>
            <td class="py-1 px-2">:</td>
            <td class="py-1 px-2 border-b border-collapse border-black"></td>
        </tr>
    </tbody>
</table>
<div class="font-bold text-sm capitalize pt-5">II. hasil analisis penilaian harian</div>
<table class="w-full text-sm">
    <tbody>
        <tr>
            <td class="py-1 px-2 w-2">1</td>
            <td class="py-1 px-2 w-80">
                @if ($namaKurikulum == 'K13')
                    a. Ketuntasan belajar rata-rata yaitu nomor
                @else
                    a. Ketercapaian belajar rata-rata yaitu nomor
                @endif
            </td>
            <td class="py-1 px-2 w-2">:</td>
            <td class="py-1 px-2 border-b border-collapse border-black"></td>
        </tr>
        <tr>
            <td class="py-1 px-2">&nbsp;</td>
            <td class="py-1 px-2">
                @if ($namaKurikulum == 'K13')
                    b. Ketidaktuntasan belajar rata-rata yaitu nomor
                @else
                    b. Ketidaktercapaian belajar rata-rata yaitu nomor
                @endif

            </td>
            <td class="py-1 px-2">:</td>
            <td class="py-1 px-2 border-b border-collapse border-black"></td>
        </tr>
        <tr>
            <td class="py-1 px-2">2</td>
            <td class="py-1 px-2">
                @if ($namaKurikulum == 'K13')
                    a. Jumlah siswa yang tuntas yaitu
                @else
                    a. Jumlah siswa yang tercapai yaitu
                @endif

            </td>
            <td class="py-1 px-2">:</td>
            <td class="py-1 px-2 border-b border-collapse border-black"></td>
        </tr>
        <tr>
            <td class="py-1 px-2">&nbsp;</td>
            <td class="py-1 px-2">
                @if ($namaKurikulum == 'K13')
                    b. Jumlah siswa yang tidak tuntas yaitu
                @else
                    b. Jumlah siswa yang tidak tercapai yaitu
                @endif

            </td>
            <td class="py-1 px-2">:</td>
            <td class="py-1 px-2 border-b border-collapse border-black"></td>
        </tr>
        <tr>
            <td class="py-1 px-2">&nbsp;</td>
            <td class="py-1 px-2">c. Jumlah semua</td>
            <td class="py-1 px-2">:</td>
            <td class="py-1 px-2 border-b border-collapse border-black"></td>
        </tr>
    </tbody>
</table>
<div class="font-bold text-sm capitalize pt-5">III. kesimpulan</div>
<table class="w-full text-sm">
    <tbody>
        <tr>
            <td class="py-1 px-2 w-2">1</td>
            <td class="py-1 px-2 w-80">
                @if ($namaKurikulum == 'K13')
                    Persentase siswa yang tuntas
                @else
                    Persentase siswa yang tercapai
                @endif
            </td>
            <td class="py-1 px-2 w-2">:</td>
            <td class="py-1 px-2">
                <u>
                    @if ($namaKurikulum == 'K13')
                        Persentase siswa yang tuntas
                    @else
                        Persentase siswa yang tercapai
                    @endif
                </u>
                X 100%
            </td>
        </tr>
        <tr>
            <td class="py-1 px-2">&nbsp;</td>
            <td class="py-1 px-2">&nbsp;</td>
            <td class="py-1 px-2">&nbsp;</td>
            <td class="py-1 px-2">Jumlah siswa</td>
        </tr>
        <tr>
            <td class="py-1 px-2">&nbsp;</td>
            <td class="py-1 px-2">&nbsp;</td>
            <td class="py-1 px-2">:</td>
            <td class="py-1 px-2">
                {{ round($listSiswa->analisisPenilaian->where('nilai', '>=', $kkm)->count() / ($listSiswa->analisisPenilaian->where('nilai', '>=', $kkm)->count() + $listSiswa->analisisPenilaian->where('nilai', '<=', $kkm)), 2) }}
                x 100%</td>
        </tr>
        <tr>
            <td class="py-1 px-2">2</td>
            <td class="py-1 px-2">Daya serap soal</td>
            <td class="py-1 px-2">:</td>
            <td class="py-1 px-2">
                {{ round($listSiswa->analisisPenilaian->where('nilai', '>=', $kkm)->count() / ($listSiswa->analisisPenilaian->where('nilai', '>=', $kkm)->count() + $listSiswa->analisisPenilaian->where('nilai', '<=', $kkm)), 2) * 100 }}
                %
            </td>
        </tr>
        <tr>
            <td class="py-1 px-2">3</td>
            <td class="py-1 px-2">Kesimpulan</td>
            <td class="py-1 px-2">:</td>
            <td class="py-1 px-2 border-b border-collapse border-black">
                Berdasarkan daya serap yang didapatkan maka soal penilaian
            </td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
            <td class="py-1 px-2 border-b border-collapse border-black">&nbsp;</td>
        </tr>
    </tbody>
</table>
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
        <div>Ngampel, {{ tanggal($listSiswa->first()->analisisPenilaian->tanggal) }}</div>
        <div>Guru Mata Pelajaran</div>
        <div class="font-bold pt-16">{{ auth()->user()->name }}</div>
    </div>
</div>
