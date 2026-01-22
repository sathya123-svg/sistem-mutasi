@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">Detail Mutasi Masuk</h1>

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

                {{-- KELAHIRAN --}}
                @foreach($kelahiran as $k)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border text-green-600 font-semibold">
                        Kelahiran
                    </td>
                    <td class="px-4 py-2 border">
                        {{ $k->penduduk->nama ?? '-' }}
                    </td>
                    <td class="px-4 py-2 border">
                        {{ $k->penduduk->nik ?? '-' }}
                    </td>
                    <td class="border px-4 py-2">
                        {{ $k->penduduk->tanggal_lahir ?? '-' }}
                    </td>
                </tr>
                @endforeach

                {{-- PENDATANG --}}
                @foreach($pendatang as $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border text-blue-600 font-semibold">
                        Pendatang
                    </td>
                    <td class="px-4 py-2 border">
                        {{ $p->penduduk->nama ?? '-' }}
                    </td>
                    <td class="px-4 py-2 border">
                        {{ $p->penduduk->nik ?? '-' }}
                    </td>
                    <td class="px-4 py-2 border">
                        {{ $p->tanggal_masuk ?? $p->created_at->format('Y-m-d') }}
                    </td>
                </tr>
                @endforeach


                @if($kelahiran->count() === 0 && $pendatang->count() === 0)
                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-500">
                        Tidak ada data mutasi masuk
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
