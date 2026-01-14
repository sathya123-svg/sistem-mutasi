@extends('layouts.app')

@section('content')
<div class="p-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Daftar Banjar</h1>

        <a href="{{ route('dashboard') }}"
           class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
            ← Kembali ke Dashboard
        </a>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-[600px] w-full border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 text-left w-16">No</th>
                    <th class="border px-4 py-2 text-left">Nama Banjar</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($banjar as $banjar)
                    <tr class="hover:bg-gray-50">
                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2 font-medium">
                            {{ $banjar->nama }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="text-center py-6 text-gray-500">
                            Tidak ada data banjar
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
