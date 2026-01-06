@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl mx-auto">

    <h1 class="text-2xl font-bold mb-4">Tambah Data KK</h1>

    <form method="POST" action="{{ route('kk.store') }}">
        @csrf

        <label>Nomor KK:</label>
        <input type="text" name="nomor_kk" class="w-full border p-2 mb-3" required>

        <label>Pilih Kepala Keluarga:</label>
        <select name="kepala_keluarga" class="w-full border p-2 mb-3" required>
            <option value="">-- Pilih --</option>
            @foreach ($penduduk as $p)
                <option value="{{ $p->id }}">{{ $p->nama }} - {{ $p->nik }}</option>
            @endforeach
        </select>

        <button
        type="submit"
        style="
            background:#dc4726 !important;
            color:#fff !important;
            padding:8px 16px !important;
            border:none !important;
            border-radius:6px !important;
            font-weight:600 !important;
            cursor:pointer !important;
        ">
        Simpan
        </button>
    </form>

</div>
@endsection
