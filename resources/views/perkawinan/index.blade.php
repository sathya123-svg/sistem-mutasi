@extends('layouts.app')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Data Perkawinan</h1>

    <a href="{{ route('perkawinan.create') }}"
       class="px-4 py-2 bg-green-600 !important text-white rounded mb-4 inline-block !important">
        + Tambah Perkawinan
    </a>
    <a href="{{ route('perkawinan.export.excel') }}"
        class="px-4 py-2 bg-red-600 !important text-white rounded mb-4 inline-block !important">
        Export Excel
    </a>


    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">tanggal Nikah</th>
                    <th class="border px-4 py-2">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($perkawinan as $p)
                <tr>
                    <td class="border px-4 py-2">{{ $p->penduduk->nama ?? "-" }}</td>
                    <td class="border px-4 py-2">
                         {{ $p->tanggal ? \Carbon\Carbon::parse($p->tanggal)->format('Y-m-d') : '-' }}
                    </td>
                    <td class="border px-4 py-2">{{ $p->keterangan }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-4 text-gray-500 ">
                        Data perkawinan belum ada
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
