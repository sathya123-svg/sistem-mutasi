@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl mx-auto">

    <h1 class="text-2xl font-bold mb-4">
        Tambah Anggota Untuk KK: {{ $kk->nomor_kk }}
    </h1>

    <form method="POST" action="{{ route('kk.storeMember', $kk->id) }}">
        @csrf

        {{-- Pilih Penduduk --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Pilih Penduduk</label>
            <select name="penduduk_id" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih --</option>
                @foreach ($penduduk as $p)
                    <option value="{{ $p->id }}">
                        {{ $p->nama }} - {{ $p->nik }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Hubungan Keluarga --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Hubungan Keluarga</label>
            <select name="hubungan_keluarga" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih --</option>
                <option value="Istri">Istri</option>
                <option value="Suami">Suami</option>
                <option value="Anak">Anak</option>
                <option value="Lainya">Lainya</option>
            </select>
        </div>

        {{-- Anak ke-berapa --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Anak Ke</label>
            <input
                type="number"
                name="anak_ke"
                min="1"
                class="w-full border p-2 rounded"
                placeholder="Isi jika hubungan = Anak">
        </div>

        {{-- Tombol --}}
        <button
            type="submit"
            style="
                background:#eb0b07 !important;
                color:#fff !important;
                padding:8px 16px !important;
                border:none !important;
                border-radius:6px !important;
                font-weight:600 !important;
                cursor:pointer !important;
            ">
            Tambah
        </button>
    </form>

</div>
@endsection
