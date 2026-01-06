@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-xl font-bold mb-4">Edit Penduduk</h1>

    <form action="{{ route('penduduk.update', $penduduk->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-4">

            <!-- NIK -->
            <div>
                <label class="block">NIK</label>
                <input type="text" name="nik"
                    class="w-full border p-2"
                    value="{{ old('nik', $penduduk->nik) }}">
            </div>

            <!-- Nama -->
            <div>
                <label class="block">Nama</label>
                <input type="text" name="nama"
                    class="w-full border p-2"
                    value="{{ old('nama', $penduduk->nama) }}" required>
            </div>

            <!-- Jenis Kelamin -->
            <div>
                <label class="block">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full border p-2" required>
                    <option value="L" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                        Laki-laki
                    </option>
                    <option value="P" {{ old('jenis_kelamin', $penduduk->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                        Perempuan
                    </option>
                </select>
            </div>

            <!-- Tanggal Lahir -->
            <div>
                <label class="block">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir"
                    class="w-full border p-2"
                    value="{{ old('tanggal_lahir', $penduduk->tanggal_lahir) }}">
            </div>

            <!-- Alamat -->
            <div>
                <label class="block">Alamat</label>
                <textarea name="alamat" class="w-full border p-2">{{ old('alamat', $penduduk->alamat) }}</textarea>
            </div>

            <!-- KK (opsional) -->
            <div>
                <label class="block">Nomor KK</label>
                <select name="kk_id" class="w-full border p-2">
                    <option value="">-- Tidak masuk KK --</option>
                    @foreach($kks as $kk)
                        <option value="{{ $kk->id }}"
                            {{ old('kk_id', $penduduk->kk_id) == $kk->id ? 'selected' : '' }}>
                            {{ $kk->nomor_kk }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Banjar -->
            <div>
                <label class="block">Banjar</label>
                <select name="banjar_id" class="w-full border p-2">
                    <option value="">-- Pilih Banjar --</option>
                    @foreach($banjars as $b)
                        <option value="{{ $b->id }}"
                            {{ old('banjar_id', $penduduk->banjar_id) == $b->id ? 'selected' : '' }}>
                            {{ $b->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol -->
                <div class="flex gap-4">
                    <button
                        type="button"
                        style="
                            background:#dc2626 !important;
                            color:#fff !important;
                            padding:8px 20px !important;
                            border:none !important;
                            border-radius:6px !important;
                            font-weight:600 !important;
                            cursor:pointer !important;
                        ">
                        Batal
                    </button>

                    <button
                        type="submit"
                        style="
                            background:#26dc20 !important;
                            color:#fff !important;
                            padding:8px 20px !important;
                            border:none !important;
                            border-radius:6px !important;
                            font-weight:600 !important;
                            cursor:pointer !important;
                        ">
                        Simpan
                    </button>
                </div>
            </div>

            @if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


        </div>
    </form>
</div>
@endsection
