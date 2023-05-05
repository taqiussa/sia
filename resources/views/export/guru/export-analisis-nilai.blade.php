<table>
    <thead>
        <tr>
            <td>tahun</td>
            <td>semester</td>
            <td>mata_pelajaran_id</td>
            <td>kategori_nilai_id</td>
            <td>jenis_penilaian_id</td>
            <td>kelas_id</td>
            <td>no</td>
            <td>nis</td>
            <td>nama</td>
            @if ($kategoriNilaiId == 3 || $kategoriNilaiId == 6)
                <td>no_1</td>
                <td>no_2</td>
                <td>no_3</td>
                <td>no_4</td>
                <td>no_5</td>
                <td>no_6</td>
                <td>no_7</td>
                <td>no_8</td>
                <td>no_9</td>
                <td>no_10</td>
            @else
                <td>aspek_1</td>
                <td>aspek_2</td>
                <td>aspek_3</td>
                <td>aspek_4</td>
            @endif
            <td>skor_maks</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($listSiswa as $siswa)
            <tr>
                <td>{{ $tahun }}</td>
                <td>{{ $semester }}</td>
                <td>{{ $mataPelajaranId }}</td>
                <td>{{ $kategoriNilaiId }}</td>
                <td>{{ $jenisPenilaianId }}</td>
                <td>{{ $kelasId }}</td>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $siswa->nis }}</td>
                <td>{{ $siswa->user->name }}</td>
                @if ($kategoriNilaiId == 3 || $kategoriNilaiId == 6)
                    <td>{{ $siswa->analisisPenilaian->no_1 }}</td>
                    <td>{{ $siswa->analisisPenilaian->no_2 }}</td>
                    <td>{{ $siswa->analisisPenilaian->no_3 }}</td>
                    <td>{{ $siswa->analisisPenilaian->no_4 }}</td>
                    <td>{{ $siswa->analisisPenilaian->no_5 }}</td>
                    <td>{{ $siswa->analisisPenilaian->no_6 }}</td>
                    <td>{{ $siswa->analisisPenilaian->no_7 }}</td>
                    <td>{{ $siswa->analisisPenilaian->no_8 }}</td>
                    <td>{{ $siswa->analisisPenilaian->no_9 }}</td>
                    <td>{{ $siswa->analisisPenilaian->no_10 }}</td>
                @else
                    <td>{{ $siswa->analisisPenilaian->no_1 }}</td>
                    <td>{{ $siswa->analisisPenilaian->no_2 }}</td>
                    <td>{{ $siswa->analisisPenilaian->no_3 }}</td>
                    <td>{{ $siswa->analisisPenilaian->no_4 }}</td>
                @endif
                <td></td>
            </tr>
        @endforeach
    </tbody>
</table>
