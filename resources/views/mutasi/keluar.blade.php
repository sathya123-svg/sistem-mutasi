@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">Detail Mutasi Keluar</h1>

    <div class="bg-white rounded shadow overflow-x-auto">
        <table class="w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Jenis Mutasi</th>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">NIK</th>
                    <th class="px-4 py-2 border">Tanggal</th>
                </tr>
            </thead>
            <tbody>

                {{-- KEMATIAN --}}
                @foreach($kematian as $k)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border text-red-600 font-semibold">
                        Kematian
                    </td>
                    <td class="px-4 py-2 border">{{ $k->nama }}</td>
                    <td class="px-4 py-2 border">{{ $k->nik }}</td>
                    <td class="px-4 py-2 border">
                        {{ $k->tanggal_kematian ?? '-' }}
                    </td>
                </tr>
                @endforeach

                {{-- PERKAWINAN --}}
                @foreach($perkawinan as $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border text-purple-600 font-semibold">
                        Perkawinan
                    </td>
                    <td class="border px-4 py-2">
                        {{ $p->penduduk->nama ?? '-' }}
                    </td>
                    <td class="border px-4 py-2">
                        {{ $p->penduduk->nik ?? '-' }}
                    </td>
                    <td class="border px-4 py-2">
                        {{ $p->tanggal ?? '-' }}
                    </td>

                </tr>
                @endforeach

                @if($kematian->count() === 0 && $perkawinan->count() === 0)
                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-500">
                        Tidak ada data mutasi keluar
                    </td>
                </tr>
                @endif

            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <a href="{{ route('dashboard') }}"
           class="inline-block px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
            ← Kembali ke Dashboard
        </a>
    </div>

</div>
@endsection
