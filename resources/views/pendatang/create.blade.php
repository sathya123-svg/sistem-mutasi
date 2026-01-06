@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">

    <h2 class="text-2xl font-semibold mb-6">Tambah Pendatang Baru</h2>

    <form method="POST" action="{{ route('pendatang.store') }}">
        @csrf

        <label class="block mb-2">Nama:</label>
        <input type="text" name="nama" class="w-full p-2 border rounded mb-4">

        <label class="block mb-2">NIK:</label>
        <input type="text" name="nik" class="w-full p-2 border rounded mb-4">

        <label>Tempat Lahir</label>
        <input type="text" name="tempat_lahir" class="w-full border p-2 rounded mb-4" >

        <label>Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full border p-2">


        <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="w-full border p-2">
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>

        <label class="block mb-2">Asal Daerah:</label>
        <input type="text" name="asal" class="w-full p-2 border rounded mb-4">
        

            <label class="block mb-2">Kewarganegaraan:</label>
        <input type="text" name="kewarganegaraan"
            class="w-full mb-4 p-2 border rounded"
            value="Indonesia">

        <label class="block mb-2">Tujuan KK:</label>
        <select name="kk_tujuan_id" class="w-full p-2 border rounded mb-4">
            @foreach ($kk as $item)
                <option value="{{ $item->id }}">
                    {{ $item->nomor_kk }} — Kepala: {{ $item->kepalaKeluargaPenduduk->nama ?? 'Tidak ada' }}
                </option>
            @endforeach
        </select>

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

        <a href="{{ route('pendatang.index') }}"
        style="
            margin-left:12px !important;
            background:#6b7280 !important;
            color:#fff !important;
            padding:8px 16px !important;
            border:none !important;
            border-radius:6px !important;
            font-weight:600 !important;
            cursor:pointer !important;
            text-decoration:none !important; 
        ">
        lihat data pendatang 
        </a>
    </form>

</div>
@endsection
