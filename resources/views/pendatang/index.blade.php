@extends('layouts.app')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Data Pendatang</h1>

    <a href="{{ route('pendatang.create') }}"
       class="px-4 py-2 bg-red-600 text-white rounded mb-4 inline-block">
        + Tambah Pendatang
    </a>
    <a href="{{ route('pendatang.export.excel') }}"
         class="px-4 py-2 bg-green-600 text-white rounded mb-4 inline-block">
         Export Excel
    </a>


    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">Nama</th>
                    <th class="border px-4 py-2">NIK</th>
                    <th class="border px-4 py-2">Asal</th>
                    <th class="border px-4 py-2">KK Tujuan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendatang as $p)
                    <tr>
                        <td class="border px-4 py-2">
                            {{ $p->penduduk->nama ?? '-' }}
                        </td>

                        <td class="border px-4 py-2">
                            {{ $p->penduduk->nik ?? '-' }}
                        </td>

                        <td class="border px-4 py-2">
                            {{ $p->asal }}
                        </td>

                        <td class="border px-4 py-2">
                            {{ $p->kkTujuan->nomor_kk ?? '-' }}
                        </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">
                        Data pendatang belum ada
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
