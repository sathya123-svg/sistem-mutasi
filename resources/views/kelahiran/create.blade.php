@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold mb-6">Tambah Data Kelahiran</h2>



    <form action="{{ route('kelahiran.store') }}" method="POST">
    @csrf

    <label class="block mb-2">Nama Bayi:</label>
    <input type="text" name="nama" class="w-full mb-4 p-2 border rounded" required>

    <label class="block mb-2">
        NIK Bayi <span class="text-sm text-gray-500">(opsional)</span>
    </label>
    <input type="text" name="nik"
        class="w-full mb-4 p-2 border rounded"
        placeholder="Kosongkan jika bayi belum memiliki NIK">

    <label class="block mb-2">Jenis Kelamin:</label>
    <select name="jenis_kelamin" class="w-full mb-4 p-2 border rounded" required>
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
    </select>

    <label class="block mb-2">Tempat Lahir:</label>
    <input type="text" name="tempat_lahir"
        class="w-full mb-4 p-2 border rounded" required>

    <label class="block mb-2">Tanggal Lahir:</label>
    <input type="date" name="tanggal_lahir"
        class="w-full mb-4 p-2 border rounded" required>

        {{-- Anak Ke --}}
    <div class="mb-4">
        <label class="block font-medium mb-1">Anak Ke</label>
        <input
            type="number"
            name="anak_ke"
            min="1"
            class="w-full border p-2 rounded"
            placeholder="Anak ke-berapa dalam keluarga"
            required
        >
    </div>

    <label class="block mb-2">Alamat:</label>
    <textarea name="alamat"
        class="w-full mb-4 p-2 border rounded"></textarea>

    <label class="block mb-2">Kewarganegaraan:</label>
    <input type="text" name="kewarganegaraan"
        class="w-full mb-4 p-2 border rounded"
        value="Indonesia">

    <label class="block mb-2">Nomor KK Tujuan:</label>
    <select name="kk_id" class="w-full mb-6 p-2 border rounded" required>
        @foreach ($KK as $item)
            <option value="{{ $item->id }}">
                {{ $item->nomor_kk }} - Kepala: {{ $item->kepalaKeluargaPenduduk->nama ?? '-' }}
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
        
            <a href="{{ route('kelahiran.index') }}"
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
        lihat data kelahiran
        </a>

</form>

</div>
@endsection
