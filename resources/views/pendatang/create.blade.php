@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">

            @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif
    
    <h2 class="text-2xl font-semibold mb-6">Tambah Pendatang Baru</h2>

    <form method="POST" action="{{ route('pendatang.store') }}">
        @csrf

        <label class="block mb-2">Nama:</label>
        <input type="text" name="nama" class="w-full p-2 border rounded mb-4" required>

        <label class="block mb-2">NIK:</label>
        <input type="text" name="nik" class="w-full p-2 border rounded mb-4" required>

        <label>Tempat Lahir</label>
        <input type="text" name="tempat_lahir" class="w-full border p-2 rounded mb-4" required >

        <label>Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full border p-2" required>


        <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="w-full border p-2" required>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>

        <label class="block mb-2">Asal Daerah:</label>
        <input type="text" name="asal" class="w-full p-2 border rounded mb-4" required>
        

            <label class="block mb-2">Kewarganegaraan:</label>
        <input type="text" name="kewarganegaraan"
            class="w-full mb-4 p-2 border rounded"
            value="Indonesia">

        <label class="block mb-2">
            Tujuan KK <span class="text-gray-500">(Opsional)</span>
        </label>

        <select name="kk_tujuan_id" class="w-full p-2 border rounded mb-1">
            <option value=""> - </option>

            @foreach ($kk as $item)
                <option value="{{ $item->id }}">
                    {{ $item->nomor_kk }}
                    — Kepala: {{ $item->kepalaKeluargaPenduduk->nama ?? 'Belum ditentukan' }}
                </option>
            @endforeach
        </select>

        <small class="text-gray-500">
            Kosongkan jika pendatang akan dijadikan kepala keluarga atau membuat KK baru
        </small>

        <div class="flex gap-2 mt-4">
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
</div>
@endsection
