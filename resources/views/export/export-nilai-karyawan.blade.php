<table>
    <thead>
        <tr>
            <td>tahun</td>
            <td>kategori_nilai_id</td>
            <td>jenis_penilaian_id</td>
            <td>user_id</td>
            <td>no</td>
            <td>nama</td>
            <td>nilai</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($listUser as $user)
            <tr>
                <td>{{ $tahun }}</td>
                <td>{{ $kategori_nilai_id }}</td>
                <td>{{ $jenis_penilaian_id }}</td>
                <td>{{ $user->id }}</td>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->penilaians->where('jenis_penilaian_id', $jenis_penilaian_id)->where('tim_id', auth()->user()->id)->first()?->nilai ?? '1' }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
