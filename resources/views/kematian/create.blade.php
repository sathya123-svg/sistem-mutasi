@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">


        @if (session('success'))
        <div class="mb-4 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

        @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif


    <h2 class="text-2xl font-semibold mb-6">Tambah Data Kematian</h2>

    <form method="POST" action="{{ route('kematian.store') }}">
        @csrf

        <label class="block mb-2">Pilih Penduduk (Nama - NIK):</label>
        <select name="penduduk_id" class="w-full p-2 border rounded mb-4">
            @foreach ($penduduk as $p)
                <option value="{{ $p->id }}">{{ $p->nama }} - {{ $p->nik }}</option>
            @endforeach
        </select>

        <label class="block mb-2">Tanggal Kematian:</label>
        <input type="date" name="tanggal_kematian" class="w-full p-2 border rounded mb-4">

        <label class="block mb-2">Keterangan:</label>
        <textarea name="keterangan" class="w-full p-2 border rounded mb-4"></textarea>

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

        <a href="{{ route('kematian.index') }}"
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
        lihat data kematian
        </a>
</div>
@endsection
