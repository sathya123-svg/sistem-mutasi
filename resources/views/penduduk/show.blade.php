@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded p-6">
            <h2 class="text-2xl font-semibold mb-4">Detail Penduduk</h2>

            <div class="mb-4">
                <strong>Nama:</strong> {{ $penduduk->nama }} <br>
                <strong>NIK:</strong> {{ $penduduk->nik }} <br>
                <strong>Alamat:</strong> {{ $penduduk->alamat }}
            </div>

            <h3 class="text-xl font-semibold mb-2">Riwayat Mutasi</h3>
            @if ($penduduk->mutasi->count() > 0)
                <table class="w-full table-auto border mt-2">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-2 py-1">Jenis</th>
                            <th class="border px-2 py-1">Tanggal</th>
                            <th class="border px-2 py-1">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penduduk->mutasi as $mutasi)
                            <tr>
                                <td class="border px-2 py-1">{{ $mutasi->jenis_mutasi }}</td>
                                <td class="border px-2 py-1">{{ $mutasi->tanggal }}</td>
                                <td class="border px-2 py-1">{{ $mutasi->keterangan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Tidak ada riwayat mutasi.</p>
            @endif

            <div class="mt-4">
                <a href="{{ route('penduduk.index') }}" class="text-blue-600 hover:underline">← Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
