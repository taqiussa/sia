<table>
    <thead>
        <tr>
            <td>tahun</td>
            <td>proyek_id</td>
            <td>dimensi_id</td>
            <td>kelas_id</td>
            <td>no</td>
            <td>nis</td>
            <td>nama</td>
            <td>dimensi</td>
            <td>nilai</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($listSiswa as $siswa)
            @foreach ($listDimensi as $dimensi)
                <tr>
                    <td>{{ $tahun }}</td>
                    <td>{{ $proyekId }}</td>
                    <td>{{ $dimensi->dimensi_id }}</td>
                    <td>{{ $kelasId }}</td>
                    <td>{{ $loop->parent->iteration }}</td>
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->user->name }}</td>
                    <td>{{ $dimensi->dimensi->nama }}</td>
                    <td>{{ $siswa->penilaianProyeks->where('dimensi_id', $dimensi->dimensi_id)->first()->nilai ?? null }}</td>
                    <td></td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
