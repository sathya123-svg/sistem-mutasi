@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Kartu Keluarga</h1>


    <!-- Tombol Aksi -->
<div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-2 mb-2">

    {{-- KIRI: KODE KAMU (TIDAK DIUBAH) --}}
    <div class="flex gap-2 justify-start">
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
          action="{{ route('penduduk.index') }}"
          class="flex gap-2 justify-end">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari nama atau No KK..."
               class="w-64 px-3 py-2 border rounded
                      focus:outline-none focus:ring focus:border-blue-400">

                <div class="flex justify-end">
                <button
                type="submit"
                style="
                    background:#0653b8 !important;
                    color:#fff !important;
                    padding:8px 16px !important;
                    border:none !important;
                    border-radius:6px !important;
                    font-weight:600 !important;
                    cursor:pointer !important;
                ">
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
                    @foreach ($kk as $k)
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
