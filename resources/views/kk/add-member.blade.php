@extends('layouts.app')

@section('content')
<div class="p-6 max-w-xl mx-auto">

    <h1 class="text-2xl font-bold mb-4">Tambah Anggota Untuk KK: {{ $kk->nomor_kk }}</h1>

    <form method="POST" action="{{ route('kk.storeMember', $kk->id) }}">
        @csrf

        <label>Pilih Penduduk:</label>
        <select name="penduduk_id" class="w-full border p-2 mb-3">
            <option value="">-- Pilih --</option>
            @foreach ($penduduk as $p)
                <option value="{{ $p->id }}">{{ $p->nama }} - {{ $p->nik }}</option>
            @endforeach
        </select>

        <button class="px-4 py-2 bg-red-600 text-white rounded">Tambah</button>
    </form>

</div>
@endsection
