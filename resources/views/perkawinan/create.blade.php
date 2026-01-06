@extends('layouts.app')

@section('content')
<div class="w-4xl mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-2xl font-semibold mb-6">Tambah Data Perkawinan</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('perkawinan.store') }}">
        @csrf

        {{-- Penduduk --}}
        <label class="block mb-2 font-medium">Pilih Penduduk</label>
        <select name="penduduk_id" class="w-full border p-2 rounded mb-4" required>
            <option value="">-- Pilih Penduduk --</option>
            @foreach ($penduduk as $p)
                <option value="{{ $p->id }}">
                    {{ $p->nama }} ({{ $p->nik }})
                </option>
            @endforeach
        </select>

        {{-- Tipe --}}
        <label class="block mb-2 font-medium">Tipe Perkawinan</label>
        <select name="tipe" id="tipe" class="w-full border p-2 rounded mb-4" required>
            <option value="">-- Pilih --</option>
            <option value="masuk">Masuk KK</option>
            <option value="keluar">Keluar KK</option>
        </select>

        {{-- KK Tujuan --}}
        <div id="kkTujuan" class="hidden">
            <label class="block mb-2 font-medium">KK Tujuan</label>
            <select name="kk_tujuan_id" class="w-full border p-2 rounded mb-4">
                <option value="">-- Pilih KK --</option>
                @foreach ($kk as $item)
                    <option value="{{ $item->id }}">
                        {{ $item->nomor_kk }} - {{ $item->kepalaKeluargaPenduduk->nama ?? '-' }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tanggal --}}
        <label class="block mb-2 font-medium">Tanggal Perkawinan</label>
        <input type="date" name="tanggal" class="w-full border p-2 rounded mb-4" required>

        {{-- Keterangan --}}
        <label class="block mb-2 font-medium">Keterangan</label>
        <textarea name="keterangan" class="w-full border p-2 rounded mb-4"></textarea>

        <button
        type="submit"
        style="
            background:#dc2626 !important;
            color:#fff !important;
            padding:8px 16px !important;
            border:none !important;
            border-radius:6px !important;
            font-weight:600 !important;
            cursor:pointer !important;
        ">
        Simpan
        </button>

            <a href="{{ route('perkawinan.index') }}"
            style="
                margin-top:16px !important;
                display:inline-block !important;
                background:#6b7280 !important;
                color:#fff !important;
                padding:8px 16px !important;
                border:none !important;
                border-radius:6px !important;
                font-weight:600 !important;
                cursor:pointer !important;
                text-decoration:none !important;
            ">
            lihat data perkawinan
            </a>
    </form>


</div>

<script>
document.getElementById('tipe').addEventListener('change', function () {
    document.getElementById('kkTujuan')
        .classList.toggle('hidden', this.value !== 'masuk');
});
</script>
@endsection
