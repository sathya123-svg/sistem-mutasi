@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">

    <h1 class="text-2xl font-bold mb-4">Detail Penduduk</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">

        <div><strong>Nama:</strong> {{ $penduduk->nama }}</div>
        <div><strong>NIK:</strong> {{ $penduduk->nik ?? '-' }}</div>

        <div><strong>Jenis Kelamin:</strong> {{ $penduduk->jenis_kelamin }}</div>
        <div><strong>Tanggal Lahir:</strong> {{ $penduduk->tanggal_lahir ?? '-' }}</div>

        <div><strong>Tempat Lahir:</strong> {{ $penduduk->tempat_lahir ?? '-' }}</div>
        <div><strong>Kewarganegaraan:</strong> {{ $penduduk->kewarganegaraan ?? '-' }}</div>

        <div class="md:col-span-2">
            <strong>Alamat:</strong><br>
            {{ $penduduk->alamat ?? '-' }}
        </div>

        <div><strong>Banjar:</strong> {{ $penduduk->banjar->nama ?? '-' }}</div>
        <div><strong>Nomor KK:</strong> {{ $penduduk->kk->nomor_kk ?? '-' }}</div>
    </div>

    <div class="mt-6 flex gap-2">
        <a href="{{ route('penduduk.edit', $penduduk->id) }}"
           class="px-4 py-2 bg-yellow-500 text-white rounded">
            Edit
        </a>

        <a href="{{ route('penduduk.index') }}"
           class="px-4 py-2 bg-gray-300 rounded">
            Kembali
        </a>
    </div>

</div>
@endsection
