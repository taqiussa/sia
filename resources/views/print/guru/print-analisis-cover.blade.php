<div class="border-2 border-black flex justify-center flex-col items-center h-[100vh]">
    <div>
        <img src="{{ asset('images/logoalfahp.png') }}" alt="logo" class="w-52">
    </div>
    <div class="font-bold text-3xl uppercase pt-7">daftar nilai</div>
    <div class="font-bold text-2xl uppercase pt-3">smp al musyaffa</div>
    <div class="font-bold text-xl uppercase pt-3">tahun pelajaran {{ $tahun }}</div>
    <div class="pt-10">
        <img src="{{ asset('images/sampul4.png') }}" alt="sampul" class="w-36">
    </div>
    <div class="flex flex-col font-bold text-sm uppercase justify-center pt-20">
        <div class="grid grid-cols-2">
            <div>nama guru</div>
            <div>: {{ auth()->user()->name }}</div>
        </div>
        <div class="grid grid-cols-2">
            <div>mata pelajaran</div>
            <div>: {{ $namaMapel }}</div>
        </div>
        <div class="grid grid-cols-2">
            <div>kelas</div>
            <div>: {{ $namaKelas }}</div>
        </div>
        <div class="grid grid-cols-2">
            <div>semester</div>
            <div>: {{ $semester }}</div>
        </div>
        <div class="grid grid-cols-2">
            <div>tahun</div>
            <div>: {{ $tahun }}</div>
        </div>
    </div>
</div>