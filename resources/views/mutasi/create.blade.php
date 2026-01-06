@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

            <h2 class="text-xl font-semibold mb-4">Tambah Data Mutasi Penduduk</h2>

            @if(session('success'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('mutasi.store') }}" method="POST">
                @csrf

                {{-- Pilih penduduk dari data --}}
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Pilih Penduduk:</label>
                    <select name="penduduk_id" class="form-select rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="">-- Pilih Penduduk --</option>
                        @foreach ($penduduk as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }} ({{ $item->nik }})</option>
                        @endforeach
                    </select>
                </div>

                {{-- Jenis Mutasi --}}
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Jenis Mutasi:</label>
                    <select name="jenis_mutasi" class="form-select rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="">-- Pilih Jenis Mutasi --</option>
                        <option value="Pindah Domisili">Pindah Domisili</option>
                        <option value="Masuk Karena Menikah">Masuk karena menikah</option>
                        <option value="Kawin Keluar">Kawin keluar</option>
                    </select>
                </div>

                {{-- Tujuan Mutasi --}}
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 mb-1">Tujuan Mutasi</label>
                    <select name="tujuan_banjar" class="form-select rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="">-- Pilih Banjar Tujuan --</option>
                        <option value="1">Banjar Tebesaya</option>
                        <option value="2">Banjar Ambengan</option>
                        <option value="3">Banjar Pande</option>
                        <option value="4">Banjar Teruna</option>
                        <option value="5">Banjar Tengah Kauh</option>
                        <option value="6">Banjar Tengah Kangin</option>
                        <option value="7">Banjar Kalah</option>
                        <option value="8">Banjar Teges Kawan</option>
                        <option value="9">Banjar Yangloni</option>
                        <option value="10">Banjar Teges Kanginan</option>
                        <option value="11">Keluar Desa</option>
                    </select>
                </div>

                {{-- Tanggal Mutasi --}}
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Tanggal Mutasi:</label>
                    <input type="date" name="tanggal" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                </div>

                {{-- Keterangan --}}
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Keterangan:</label>
                    <textarea name="keterangan" rows="3" class="form-input rounded-md shadow-sm mt-1 block w-full"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-black rounded hover:bg-blue-700">
                        Simpan Mutasi
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
