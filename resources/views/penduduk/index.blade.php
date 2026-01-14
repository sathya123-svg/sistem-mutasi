@extends('layouts.app')

@section('content')
<div class="px-6 pt-6 pb-2">


    <!-- Judul -->
    <h1 class="text-2xl font-bold mb-4">Data Penduduk</h1>

<!-- Tombol Aksi + Search -->
<div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-2 mb-2">

    {{-- KIRI: TOMBOL --}}
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('penduduk.create') }}"
           class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
            + Tambah Penduduk
        </a>

        <a href="{{ route('penduduk.import.form') }}"
           class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
            Import
        </a>

        <a href="{{ route('penduduk.export.excel') }}"
           class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            Export Excel
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

        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-blackrounded hover:bg-blue-700">
            Cari
        </button>
    </form>

</div>





    

    <!-- Card -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">
             <table class="min-w-[900px] w-full border border-gray-200">
                <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">NIK</th>
                    <th class="px-4 py-2 border">KK</th>
                    <th class="px-4 py-2 border">Jenis Kelamin</th>
                    <th class="px-4 py-2 border">Tempat Lahir</th>
                    <th class="px-4 py-2 border">Tanggal Lahir</th>
                    <th class="px-4 py-2 border">Alamat</th>
                    <th class="px-4 py-2 border">Banjar</th>
                    <th class="px-4 py-2 border">Kewarganegaraan</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($penduduk as $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border font-medium">{{ $p->nama }}</td>
                    <td class="px-4 py-2 border">{{ $p->nik ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $p->kk->nomor_kk ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $p->jenis_kelamin ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $p->tempat_lahir ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $p->tanggal_lahir ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $p->alamat ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $p->banjar->nama ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $p->kewarganegaraan ?? '-' }}</td>
                    <td class="px-4 py-2 border whitespace-nowrap">
                        <a href="{{ route('penduduk.show', $p->id) }}" class="text-blue-600 hover:underline">Lihat</a>
                        <a href="{{ route('penduduk.edit', $p->id) }}" class="text-yellow-600 hover:underline ml-2">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-4 text-gray-500">
                        Data penduduk belum tersedia
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

</div>
@endsection


{{-- @extends('layouts.app') @section('content') <div class="p-6"> <!-- Judul --> <h1 class="text-2xl font-bold mb-4">Data Penduduk</h1> <!-- Tombol Aksi --> <div class="flex gap-2 mb-4"> <a href="{{ route('penduduk.create') }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"> + Tambah Penduduk </a> <a href="{{ route('penduduk.import.form') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300"> Import </a> <a href="{{ route('penduduk.export.excel') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"> Export Excel </a> </div> <!-- Card --> <div class="bg-white rounded shadow overflow-x-auto"> <table class="min-w-full border border-gray-200"> <thead class="bg-gray-100 text-left"> <tr> <th class="px-4 py-2 border">Nama</th> <th class="px-4 py-2 border">NIK</th> <th class="px-4 py-2 border">KK</th> <th class="px-4 py-2 border">Jenis Kelamin</th> <th class="px-4 py-2 border">Tempat Lahir</th> <th class="px-4 py-2 border">Tanggal Lahir</th> <th class="px-4 py-2 border">Alamat</th> <th class="px-4 py-2 border">Banjar</th> <th class="px-4 py-2 border">Kewarganegaraan</th> <th class="px-4 py-2 border">Aksi</th> </tr> </thead> <tbody> @forelse ($penduduk as $p) <tr class="hover:bg-gray-50"> <td class="px-4 py-2 border">{{ $p->nama }}</td> <td class="px-4 py-2 border"> {{ $p->nik ?? '-' }} </td> <td class="px-4 py-2 border"> {{ $p->kk->nomor_kk ?? '-' }} </td> <td class="px-4 py-2 border"> {{ $p->jenis_kelamin ?? '-' }} </td> <td class="px-4 py-2 border"> {{ $p->tempat_lahir ?? '-' }} </td> <td class="px-4 py-2 border"> {{ $p->tanggal_lahir ?? '-' }} </td> <td class="px-4 py-2 border"> {{ $p->alamat ?? '-' }} </td> <td class="px-4 py-2 border"> {{ $p->banjar->nama ?? '-' }} </td> <td class="px-4 py-2 border"> {{ $p->kewarganegaraan ?? '-' }} </td> <td class="px-4 py-2 border space-x-2"> <a href="{{ route('penduduk.show', $p->id) }}" class="text-blue-600 hover:underline">Lihat</a> <a href="{{ route('penduduk.edit', $p->id) }}" class="text-yellow-600 hover:underline">Edit</a> </td> </tr> @empty <tr> <td colspan="10" class="text-center py-4 text-gray-500"> Data penduduk belum tersedia </td> </tr> @endforelse </tbody> </table> </div> </div> @endsection --}}