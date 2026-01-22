@extends('layouts.app')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Data Mutasi Keluar</h1>

    <a href="{{ route('mutasi_keluar.create') }}"
       class="px-4 py-2 bg-red-600 text-white rounded mb-4 inline-block">
        + Tambah Mutasi Keluar
    </a>

    <div class="bg-white rounded shadow overflow-x-auto mt-4">
        <table class="w-full border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">NIK</th>
                    <th class="border px-4 py-2">No KK</th>
                    <th class="border px-4 py-2">Tanggal Keluar</th>
                    <th class="border px-4 py-2">Alasan</th>
                    <th class="border px-4 py-2">Tujuan Daerah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $m)
                <tr>
                    <td class="border px-4 py-2">{{ $m->nama }}</td>
                    <td class="border px-4 py-2">{{ $m->nik }}</td>
                    <td class="border px-4 py-2">{{ $m->nomor_kk ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $m->tanggal_keluar }}</td>
                    <td class="border px-4 py-2">{{ $m->alasan }}</td>
                    <td class="border px-4 py-2">{{ $m->tujuan_daerah ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">
                        Data mutasi keluar belum ada
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
