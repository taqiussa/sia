<table>
    <thead>
        <tr>
            <td>jenis_analisis</td>
            <td>tahun</td>
            <td>semester</td>
            <td>kategori_nilai_id</td>
            <td>jenis_penilaian_id</td>
            <td>kelas_id</td>
            <td>no</td>
            <td>nis</td>
            <td>nama</td>
            <td>kelancaran</td>
            <td>makhroj</td>
            <td>tajwid</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($listSiswa as $siswa)
            <tr>
                <td>{{ $jenisAnalisis }}</td>
                <td>{{ $tahun }}</td>
                <td>{{ $semester }}</td>
                <td>{{ $kategoriNilaiId }}</td>
                <td>{{ $jenisPenilaianId }}</td>
                <td>{{ $kelasId }}</td>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $siswa->nis }}</td>
                <td>{{ $siswa->user->name }}</td>
                <td>
                    @foreach ($siswa->analisisAlqurans->where('indikator', 3) as $nilai)
                        {{ $nilai->nilai }}
                    @endforeach
                </td>
                <td>
                    @foreach ($siswa->analisisAlqurans->where('indikator', 4) as $nilai)
                        {{ $nilai->nilai }}
                    @endforeach
                </td>
                <td>
                    @foreach ($siswa->analisisAlqurans->where('indikator', 5) as $nilai)
                        {{ $nilai->nilai }}
                    @endforeach
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
