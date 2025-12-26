@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <h2 class="text-lg font-semibold mb-4">Data Penduduk</h2>

                <div class="mb-4">
                    <a href="{{ route('penduduk.create') }}" class="px-4 py-2 bg-green-600 text-black rounded hover:bg-green-700">Tambah Penduduk</a>
                    <a href="{{ route('penduduk.export.excel') }}" class="px-4 py-2 bg-yellow-500 text-Black rounded hover:bg-yellow-600 ml-2">Export Excel</a>
                    <a href="{{ route('penduduk.export.pdf') }}" class="px-4 py-2 bg-red-500 text-Black rounded hover:bg-red-600 ml-2">Export PDF</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-300 text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2">NIK</th>
                                <th class="border px-4 py-2">Nama</th>
                                <th class="border px-4 py-2">Alamat</th>
                                <th class="border px-4 py-2">Jenis Kelamin</th>
                                <th class="border px-4 py-2">Tanggal Lahir</th>
                                <th class="border px-4 py-2">Banjar</th>
                                <th class="border px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penduduk as $p)
                                <tr>
                                    <td class="border px-4 py-2">{{ $p->nik }}</td>
                                    <td class="border px-4 py-2">{{ $p->nama }}</td>
                                    <td class="border px-4 py-2">{{ $p->alamat }}</td>
                                    <td class="border px-4 py-2">{{ $p->jenis_kelamin }}</td>
                                    <td class="border px-4 py-2">{{ $p->tanggal_lahir }}</td>
                                    <td class="border px-4 py-2">{{ $p->banjar ? $p->banjar->nama : '-' }}</td>
                                    <td class="border px-4 py-2 space-x-2">
                                        <a href="{{ route('penduduk.edit', $p->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                        <form action="{{ route('penduduk.destroy', $p->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
