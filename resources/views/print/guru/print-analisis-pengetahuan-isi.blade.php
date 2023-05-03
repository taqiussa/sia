<div>
    <div class="flex justify-between">
        <div>
            <img src="{{ asset('images/logoalfahp.png') }}" alt="logohp" class="h-20">
        </div>
        <div class="font-bold text-md flex flex-col justify-center uppercase text-center">
            <div>analisis {{ $jenisPenilaian }}</div>
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
                <div>tahun</div>
                <div>: {{ $tahun }}</div>
            </div>
        </div>
    </div>
    <div class="font-bold text-xs capitalize flex flex-row pt-2 border-b border-black">
        <div>wali kelas</div>
        <div>: {{ $namaWaliKelas }}</div>
    </div>
    <table class="w-full text-[8px] font-semibold">
        <thead>
            <tr>
                <th class="border border-collapse border-black" rowspan="2">No</th>
                <th class="border border-collapse border-black" rowspan="2">NIS</th>
                <th class="border border-collapse border-black" rowspan="2">Nama</th>
                <th class="border border-collapse border-black" colspan="10">Nomor Soal</th>
                <th class="border border-collapse border-black" rowspan="2">Nilai</th>
                <th class="border border-collapse border-black" colspan="2">
                    @if ($namaKurikulum == 'K13')
                        Tuntas
                    @else
                        Keterangan
                    @endif
                </th>
            </tr>
            <tr>
                <th class="border border-collapse border-black">1</th>
                <th class="border border-collapse border-black">2</th>
                <th class="border border-collapse border-black">3</th>
                <th class="border border-collapse border-black">4</th>
                <th class="border border-collapse border-black">5</th>
                <th class="border border-collapse border-black">6</th>
                <th class="border border-collapse border-black">7</th>
                <th class="border border-collapse border-black">8</th>
                <th class="border border-collapse border-black">9</th>
                <th class="border border-collapse border-black">10</th>
                <th class="border border-collapse border-black">
                    @if ($namaKurikulum == 'K13')
                        Ya
                    @else
                        TC
                    @endif
                </th>
                <th class="border border-collapse border-black">
                    @if ($namaKurikulum == 'K13')
                        Tidak
                    @else
                        BTC
                    @endif
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($listSiswa as $siswa)
                <tr>
                    <td class="border border-collapse border-black px-2 py-1 text-center">{{ $loop->iteration }}</td>
                    <td class="border border-collapse border-black px-2 py-1 text-center">{{ $siswa->nis }}</td>
                    <td class="border border-collapse border-black px-2 py-1">{{ $siswa->user?->name }}</td>
                    <td class="border border-collapse border-black px-2 py-1 text-center">
                        {{ $siswa->analisisPenilaian?->no_1 }}</td>
                    <td class="border border-collapse border-black px-2 py-1 text-center">
                        {{ $siswa->analisisPenilaian?->no_2 }}</td>
                    <td class="border border-collapse border-black px-2 py-1 text-center">
                        {{ $siswa->analisisPenilaian?->no_3 }}</td>
                    <td class="border border-collapse border-black px-2 py-1 text-center">
                        {{ $siswa->analisisPenilaian?->no_4 }}</td>
                    <td class="border border-collapse border-black px-2 py-1 text-center">
                        {{ $siswa->analisisPenilaian?->no_5 }}</td>
                    <td class="border border-collapse border-black px-2 py-1 text-center">
                        {{ $siswa->analisisPenilaian?->no_6 }}</td>
                    <td class="border border-collapse border-black px-2 py-1 text-center">
                        {{ $siswa->analisisPenilaian?->no_7 }}</td>
                    <td class="border border-collapse border-black px-2 py-1 text-center">
                        {{ $siswa->analisisPenilaian?->no_8 }}</td>
                    <td class="border border-collapse border-black px-2 py-1 text-center">
                        {{ $siswa->analisisPenilaian?->no_9 }}</td>
                    <td class="border border-collapse border-black px-2 py-1 text-center">
                        {{ $siswa->analisisPenilaian?->no_10 }}</td>
                    <td class="border border-collapse border-black px-2 py-1 text-center">
                        {{ $siswa->analisisPenilaian?->nilai }}</td>
                    @if ($siswa->analisisPenilaian->nilai >= $kkm)
                        <td class="border border-collapse border-black px-2 py-1">
                            <div class="flex justify-center items-center">
                                <svg style="width:14px;height:14px" viewBox="0 0 22 22">
                                    <path fill="currentColor"
                                        d="M12 2C6.5 2 2 6.5 2 12S6.5 22 12 22 22 17.5 22 12 17.5 2 12 2M10 17L5 12L6.41 10.59L10 14.17L17.59 6.58L19 8L10 17Z" />
                                </svg>
                            </div>
                        </td>
                        <td class="border border-collapse border-black px-2 py-1"></td>
                    @else
                        <td class="border border-collapse border-black px-2 py-1"></td>
                        <td class="border border-collapse border-black px-2 py-1">
                            <div class="flex justify-center items-center">
                                <svg style="width:14px;height:14px" viewBox="0 0 22 22">
                                    <path fill="currentColor"
                                        d="M12 2C6.5 2 2 6.5 2 12S6.5 22 12 22 22 17.5 22 12 17.5 2 12 2M10 17L5 12L6.41 10.59L10 14.17L17.59 6.58L19 8L10 17Z" />
                                </svg>
                            </div>
                        </td>
                    @endif
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
</div>
