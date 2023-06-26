<table>
    <thead>
        <tr>
            <td>tahun</td>
            <td>semester</td>
            <td>mata_pelajaran_id</td>
            <td>kategori_sikap_id</td>
            <td>jenis_sikap_id</td>
            <td>kelas_id</td>
            <td>no</td>
            <td>nis</td>
            <td>nama</td>
            <td>jenis_sikap</td>
            <td>nilai</td>
            <td>tindak_lanjut</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($listSiswa as $siswa)
            @foreach ($listJenis as $jenis)
                <tr>
                    <td>{{ $tahun }}</td>
                    <td>{{ $semester }}</td>
                    <td>{{ $mataPelajaranId }}</td>
                    <td>{{ $kategoriSikapId }}</td>
                    <td>{{ $jenis->id }}</td>
                    <td>{{ $kelasId }}</td>
                    <td>{{ $loop->parent->iteration }}</td>
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->user->name }}</td>
                    <td>{{ $jenis->nama }}</td>
                    <td>{{ $siswa->penilaianSikap->nilai ?? null }}</td>
                    <td></td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
