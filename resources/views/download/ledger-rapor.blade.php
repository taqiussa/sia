<table>
    <thead>
        <tr>
            <td>no</td>
            <td>nis</td>
            <td>nama</td>
            @foreach ($listMapel as $mapel)
                <td>{{ $mapel->mapel->nama }}</td>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($listSiswa as $siswa)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $siswa->nis }}</td>
                <td>{{ $siswa->user->name }}</td>
                @foreach ($listMapel as $mapel)
                    @php
                        $avg = floor(
                            $siswa->penilaians
                                ->where('mata_pelajaran_id', $mapel->mata_pelajaran_id)
                                ->whereIn('jenis_penilaian_id', $listJenis)
                                ->avg('nilai'),
                        );
                    @endphp
                    <td>
                        {{ $avg }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
