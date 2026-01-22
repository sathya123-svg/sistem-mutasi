@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Tambah Mutasi Keluar</h1>

    <form action="{{ route('mutasi_keluar.store') }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf

        {{-- Pilih Penduduk --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Penduduk</label>
            <select name="penduduk_id" class="w-full border rounded p-2" required>
                <option value="">-- Pilih Penduduk --</option>
                @foreach($penduduk as $p)
                    <option value="{{ $p->id }}">
                        {{ $p->nama }} - {{ $p->nik }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tanggal Keluar --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Tanggal Keluar</label>
            <input type="date" name="tanggal_keluar" class="w-full border rounded p-2" required>
        </div>

        {{-- Alasan --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Alasan Mutasi</label>
            <input type="text" name="alasan" class="w-full border rounded p-2"
                   placeholder="Contoh: Pindah domisili" required>
        </div>

        {{-- Tujuan Daerah --}}
        <div class="mb-6">
            <label class="block font-medium mb-1">Tujuan Daerah</label>
            <input type="text" name="tujuan_daerah" class="w-full border rounded p-2"
                   placeholder="Contoh: Denpasar / Singaraja">
        </div>

        {{-- Tombol --}}
        <div class="flex gap-2">
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
            <a href="{{ route('mutasi_keluar.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection
