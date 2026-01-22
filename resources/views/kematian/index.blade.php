@extends('layouts.app')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Data Kematian</h1>

    <a href="{{ route('kematian.create') }}"
       class="px-4 py-2 bg-red-600 text-white rounded mb-4 inline-block">
        + Tambah Data Kematian
    </a>
    <a href="{{ route('kematian.export.excel', request()->query()) }}"
   class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
    Export Excel
</a>


    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">NIK</th>
                    <th class="border px-4 py-2">No KK</th>
                    <th class="border px-4 py-2">Tanggal Meninggal</th>
                    <th class="border px-4 py-2">keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kematian as $k)
                <tr>
                    <td class="border px-4 py-2">{{ $k->nama }}</td>
                    <td class="border px-4 py-2">{{ $k->nik }}</td>
                    <td class="border px-4 py-2">{{ $k->nomor_kk ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $k->tanggal_kematian }}</td>
                    <td class="border px-4 py-2">{{ $k->keterangan }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">
                        Data kematian belum ada
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
