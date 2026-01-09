@extends('layouts.app')

@section('content')
<div class="p-6 max-w-7xl mx-auto">

{{-- JUDUL --}}
<h1 class="text-2xl font-bold mb-4">Data Kelahiran</h1>

{{-- BARIS KONTROL --}}
<div class="flex items-center justify-between mb-4 gap-4">

    {{-- KIRI: TOMBOL --}}
    <div class="flex gap-2">
        <a href="{{ route('kelahiran.create') }}"
           class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
            + Tambah Data Kelahiran
        </a>

        {{-- EXPORT --}}
        <a href="{{ route('kelahiran.export.excel', request()->query()) }}"
           class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Export Excel
        </a>
    </div>

    {{-- KANAN: SEARCH --}}
    <form method="GET" class="flex items-center gap-2">
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari nama / NIK bayi"
            class="border rounded px-3 py-2 w-64 focus:ring focus:border-blue-400"
        >

        <button class="bg-blue-600 text-black px-4 py-2 rounded hover:bg-blue-700">
            Cari
        </button>

        @if(request('q'))
            <a href="{{ route('kelahiran.index') }}"
               class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                Reset
            </a>
        @endif
    </form>

</div>


    {{-- TABEL --}}
    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 text-left">Nama</th>
                    <th class="border px-4 py-2 text-left">NIK</th>
                    <th class="border px-4 py-2 text-left">No KK</th>
                    <th class="border px-4 py-2 text-left">Tanggal Lahir</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelahiran as $k)
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">
                        {{ $k->penduduk->nama }}
                    </td>
                    <td class="border px-4 py-2">
                        {{ $k->penduduk->nik }}
                    </td>
                    <td class="border px-4 py-2">
                        {{ $k->kkTujuan->nomor_kk ?? '-' }}
                    </td>
                    <td class="border px-4 py-2">
                        {{ $k->penduduk->tanggal_lahir ?? '-' }}
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-6 text-gray-500">
                        Data kelahiran belum ada
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
