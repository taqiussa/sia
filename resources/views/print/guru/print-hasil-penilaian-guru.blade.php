@extends('print-no-header-rata')
@section('title', 'Print Hasil Penilaian Guru')
@section('content')
    <div class="font-bold text-center text-md capitalize mb-2 border-b-2 border-black">ledger raport pendidik dan tenaga
        kependidikan tahun {{ $tahun }}</div>
    <table class="w-full pt-3 text-xs">
        <thead>
            <tr>
                <th rowspan="2" class="border border-collapse border-black">Rank</th>
                <th rowspan="2" class="border border-collapse border-black">Nama</th>
                @foreach ($listJenis as $jenis)
                    <th class="border border-collapse border-black">{{ $jenis->jenis?->nama }}</th>
                @endforeach
                <th rowspan="2" class="border border-collapse border-black">Rata-rata</th>
            </tr>
            <tr>
                @foreach ($listJenis as $jenis)
                    <th class="border border-collapse border-black">{{ $jenis->kkm?->kkm }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($listUser as $user)
                <tr>
                    <td class="border border-collapse border-black text-center px-1">{{ $loop->iteration }}</td>
                    <td class="border border-collapse border-black px-2">{{ $user->name ?? $user->user->name }}</td>
                    @foreach ($listJenis as $jenis)
                        <td class="border border-collapse border-black text-center px-1">
                            {{-- @foreach ($user->penilaians as $nilai) --}}
                            @if ($nilai->jenis_penilaian_id == $jenis->jenis_penilaian_id)
                                <div
                                    class="{{ $user->penilaians->where('jenis_penilaian_id', $jenis->jenis_penilaian_id)->avg('nilai') < $jenis->kkm->kkm ? 'text-red-600 bg-yellow-400' : '' }}">
                                    {{ $user->penilaians->where('jenis_penilaian_id', $jenis->jenis_penilaian_id)->avg('nilai') }}
                                    {{-- ({{ $user->nilai->nilai }}) --}}
                                </div>
                            @endif
                            {{-- @endforeach --}}
                        </td>
                    @endforeach
                    <td class="border border-collapse border-black text-center px-1">
                        {{ floor($user->penilaians->avg('nilai')) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="flex justify-between items-start text-sm pt-3 px-10">
        <div class="flex flex-col items-center justify-center">
            <div>Mengetahui,</div>
            <div>Kepala Sekolah</div>
            <div class="font-bold pt-16">Abdul Khalim, S.Pd</div>
        </div>
        <div class="flex flex-col items-center justify-center">
            <div>Ngampel, {{ tanggal(date('Y-m-d')) }}</div>
            <div>Kaur. Ketenagaan</div>
            <div class="font-bold pt-16">Fathurrohman, S.Pd</div>
        </div>
    </div>
@endsection
