@extends('layouts.app')

    @section('content')
        <div class="max-w-6xl mx-auto p-6">

            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    Detail Mutasi Keluar
                </h1>

                {{-- <a href="{{ route('dashboard') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                    ← Kembali ke Dashboard
                </a> --}}
            </div>

            

            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 border">Jenis Mutasi</th>
                            <th class="px-4 py-3 border">Nama</th>
                            <th class="px-4 py-3 border">NIK</th>
                            <th class="px-4 py-3 border">Tanggal</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700">

                        {{-- ===================== --}}
                        {{-- KEMATIAN --}}
                        {{-- ===================== --}}
                        @foreach($kematian as $k)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border text-red-600 font-semibold">
                                Kematian
                            </td>
                            <td class="px-4 py-2 border">
                                {{ $k->nama }}
                            </td>
                            <td class="px-4 py-2 border">
                                {{ $k->nik }}
                            </td>
                            <td class="px-4 py-2 border">
                                {{ \Carbon\Carbon::parse($k->tanggal_kematian)->format('d-m-Y') }}
                            </td>
                        </tr>
                        @endforeach

                        {{-- ===================== --}}
                        {{-- PERKAWINAN KELUAR --}}
                        {{-- ===================== --}}
                        @foreach($perkawinan as $p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border text-purple-600 font-semibold">
                                Perkawinan
                            </td>
                            <td class="px-4 py-2 border">
                                {{ $p->nama ?? '-' }}
                            </td>
                            <td class="px-4 py-2 border">
                                {{ $p->nik ?? '-' }}
                            </td>
                            <td class="px-4 py-2 border">
                                {{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}
                            </td>
                        </tr>
                        @endforeach

                        {{-- ===================== --}}
                        {{-- MUTASI KELUAR --}}
                        {{-- ===================== --}}
                        @foreach($mutasiKeluar as $m)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border text-blue-600 font-semibold">
                                Mutasi Keluar
                            </td>
                            <td class="px-4 py-2 border">
                                {{ $m->nama ?? '-' }}
                            </td>
                            <td class="px-4 py-2 border">
                                {{ $m->nik ?? '-' }}
                            </td>
                            <td class="px-4 py-2 border">
                                {{ \Carbon\Carbon::parse($m->tanggal)->format('d-m-Y') }}
                            </td>
                        </tr>
                        @endforeach

                        {{-- ===================== --}}
                        {{-- EMPTY STATE --}}
                        {{-- ===================== --}}
                        @if($kematian->isEmpty() && $perkawinan->isEmpty() && $mutasiKeluar->isEmpty())
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
