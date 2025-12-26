@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Daftar Mutasi Penduduk</h1>

    <a href="{{ route('mutasi.create') }}" class="bg-blue-200 text-black px-4 py-2 rounded mb-4 inline-block">+ Tambah Mutasi</a>

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2 border">Nama</th>
                <th class="px-4 py-2 border">Jenis Mutasi</th>
                <th class="px-4 py-2 border">Tanggal</th>
                <th class="px-4 py-2 border">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($mutasi as $item)
            <tr>
                <td class="border px-4 py-2">{{ $item->penduduk->nama }}</td>
                <td class="border px-4 py-2">{{ $item->jenis_mutasi }}</td>
                <td class="border px-4 py-2">{{ $item->tanggal }}</td>
                <td class="border px-4 py-2">{{ $item->keterangan }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-4">Belum ada data mutasi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
