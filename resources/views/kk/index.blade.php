@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Kartu Keluarga</h1>


    <!-- Tombol Aksi -->
<div class="flex flex-col gap-3 mb-4 md:flex-row md:items-center md:justify-between">

    {{-- KIRI: KODE KAMU (TIDAK DIUBAH) --}}
    <div class="flex gap-2 flex-wrap">
        <a href="{{ route('kk.create') }}"
           class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
            + Tambah KK
        </a>

        <a href="{{ route('penduduk.index') }}"
           class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
            Data Penduduk
        </a>

        <a href="{{ route('penduduk.create') }}"
           class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            + Tambah Penduduk
        </a>

        <a href="{{ route('kk.export.excel') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Export KK Excel
        </a>
    </div>

    {{-- KANAN: SEARCH --}}
    <form method="GET"
      action="{{ route('kk.index') }}"
      class="flex gap-2 w-full md:w-auto">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari kepala keluarga / nomor KK..."
               class="px-3 py-2 border rounded w-64">

        <button class="px-4 py-2 bg-blue-600 text-black rounded">
            Cari
        </button>
    </form>

</div>



    {{-- <!-- Tambah KK -->
    <a href="{{ route('kk.create') }}"
       class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
        + Tambah KK
    </a>

    <a href="{{ route('penduduk.index') }}"
       class="px-4 py-2 bg-blue-600 text-white rounded">
       Data Penduduk
    </a>

    <!-- Tambah Penduduk -->
    <a href="{{ route('penduduk.create') }}"
       class="px-4 py-2 bg-red-600 text-white rounded hover:bg-green-700">
        + Tambah Penduduk
    </a>
</div> --}}
        <div class="bg-white rounded-lg shadow overflow-x-auto">
             <table class="min-w-[900px] w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2 text-left">No KK</th>
                        <th class="border px-4 py-2 text-left">Kepala Keluarga</th>
                        <th class="border px-4 py-2 text-left">Jumlah Anggota</th>
                        <th class="border px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($KK as $k)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $k->nomor_kk }}</td>
                        <td class="border px-4 py-2">
                            {{ $k->kepalaKeluargaPenduduk->nama ?? '-' }}
                        </td>
                        <td class="border px-4 py-2">
                            {{ $k->anggota->count() }}
                        </td>
                        <td class="border px-4 py-2 whitespace-nowrap">
                            <a href="{{ route('kk.show', $k->id) }}"
                            class="text-blue-600 hover:underline">
                                Lihat
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

</div>
@endsection
