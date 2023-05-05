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
            <td>nilai</td>
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
                <td>{{ $siswa->penilaian->nilai }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
