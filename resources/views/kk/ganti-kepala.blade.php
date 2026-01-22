@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">

    {{-- Error --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <h2 class="text-2xl font-semibold mb-6">
        Ganti Kepala Keluarga
    </h2>

    {{-- Info KK --}}
    <div class="mb-6">
        <p class="mb-2">
            <strong>Nomor KK:</strong><br>
            <span class="text-gray-700">{{ $kk->nomor_kk }}</span>
        </p>

        <p>
            <strong>Kepala Keluarga Lama:</strong><br>
            <span class="text-gray-700">
                {{ $kk->kepalaKeluarga->nama ?? '-' }}
            </span>
        </p>
    </div>

    <form method="POST" action="{{ route('kk.ganti-kepala', $kk->id) }}">
        @csrf

        <label class="block mb-2">
            Pilih Kepala Keluarga Baru:
        </label>

        <select name="kepala_keluarga_id"
                class="w-full p-2 border rounded mb-6"
                required>
            <option value="">-- Pilih --</option>
            @foreach ($calon as $c)
                <option value="{{ $c->id }}">
                    {{ $c->nama }} - {{ $c->nik }}
                </option>
            @endforeach
        </select>

        {{-- Tombol --}}
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

        <a href="{{ route('kk.show', $kk->id) }}"
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
            Batal
        </a>

    </form>
</div>
@endsection
