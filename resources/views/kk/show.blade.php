@extends('layouts.app')

@section('content')
<div class="p-6">

    <!-- Judul -->
    <h1 class="text-2xl font-bold mb-4">Detail KK</h1>

<!-- Info KK -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <div class="flex items-center justify-between">

        {{-- Info --}}
        <div>
            <p class="mb-1">
                <strong>Nomor KK:</strong>
                <span class="text-gray-700">{{ $kk->nomor_kk }}</span>
            </p>
            <p>
                <strong>Kepala Keluarga:</strong>
                <span class="text-gray-700">
                    {{ $kk->kepalaKeluargaPenduduk->nama ?? '-' }}
                </span>
            </p>
        </div>

        {{-- Aksi --}}
        <a href="{{ route('kk.ganti-kepala.form', $kk->id) }}"
           class="px-4 py-2 bg-green-600 text-white rounded-md
                  hover:bg-green-700 transition">
            Ganti Kepala Keluarga
        </a>

    </div>
</div>


    <!-- Header Anggota -->
    <div class="flex items-center justify-between mb-3">
        <h2 class="text-xl font-semibold">Anggota Keluarga</h2>

        <a href="{{ route('kk.addMember', $kk->id) }}"
           class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            + Tambah Anggota
        </a>
    </div>

    <!-- Tabel Responsif -->
    <div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="min-w-[900px] w-full border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border text-left">Nama</th>
                <th class="px-4 py-2 border text-left">NIK</th>
                <th class="px-4 py-2 border text-left">Jenis Kelamin</th>
                <th class="px-4 py-2 border text-left">Tempat Lahir</th>
                <th class="px-4 py-2 border text-left">Tanggal Lahir</th>
                <th class="px-4 py-2 border text-left">Hubungan Keluarga</th>
                <th class="px-4 py-2 border text-left">Anak Ke</th>
                <th class="px-4 py-2 border text-left">Aksi</th>

                {{-- <th class="px-4 py-2 border text-left">Banjar</th>
                <th class="px-4 py-2 border text-left">Aksi</th> --}}
            </tr>
        </thead>

        <tbody>
            @forelse($kk->anggota as $a)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border">{{ $a->nama }}</td>
                <td class="px-4 py-2 border">{{ $a->nik }}</td>
                <td class="px-4 py-2 border">
                    {{ $a->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                </td>
                <td class="px-4 py-2 border">{{ $a->tempat_lahir ?? '-' }}</td>
                <td class="px-4 py-2 border">{{ $a->tanggal_lahir ?? '-' }}</td>
                <td class="px-4 py-2 border">
                    {{ $a->hubungan_keluarga ?? '-' }}
                </td>

                <td class="px-4 py-2 border">
                    {{ $a->hubungan_keluarga === 'Anak' ? $a->anak_ke : '-' }}
                </td>

                <td class="px-4 py-2 border whitespace-nowrap">
                    <a href="{{ route('kk.editAnggota', [$kk->id, $a->id]) }}"
                    class="bg-blue-600 text-white px-3 py-1 rounded text-sm">
                        Edit
                    </a>
                </td>

                {{-- <td class="px-4 py-2 border">{{ $a->banjar->nama ?? '-' }}</td>
                <td class="px-4 py-2 border whitespace-nowrap space-x-2">
                    <a href="{{ route('penduduk.show', $a->id) }}" class="text-blue-600">Lihat</a>
                    <a href="{{ route('penduduk.edit', $a->id) }}" class="text-yellow-600">Edit</a>
                </td> --}}
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-4 py-4 text-center text-gray-500">
                    Belum ada anggota keluarga
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


</div>
@endsection
