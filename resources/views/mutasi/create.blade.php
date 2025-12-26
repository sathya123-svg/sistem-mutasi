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

                {{-- Pilih apakah penduduk sudah terdaftar --}}
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700 mb-1">Apakah penduduk sudah terdaftar?</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center">
                            <input type="radio" name="penduduk_terdaftar" value="1" checked class="form-radio text-blue-600" onclick="toggleForm()">
                            <span class="ml-2">Ya, pilih dari data</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="penduduk_terdaftar" value="0" class="form-radio text-blue-600" onclick="toggleForm()">
                            <span class="ml-2">Belum, tambahkan penduduk baru</span>
                        </label>
                    </div>
                </div>



                {{-- Form pilih penduduk lama --}}
                <div id="formLama" class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Pilih Penduduk:</label>
                    <select name="penduduk_id" class="form-select rounded-md shadow-sm mt-1 block w-full">
                        <option value="">-- Pilih Penduduk --</option>
                        @foreach ($penduduk as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }} ({{ $item->nik }})</option>
                        @endforeach
                    </select>
                </div>

                {{-- Form penduduk baru --}}
                <div id="formBaru" class="mb-4 hidden">
                    <div class="mb-2">
                        <label class="block font-medium text-sm text-gray-700">Nama:</label>
                        <input type="text" name="nama" class="form-input rounded-md shadow-sm mt-1 block w-full">
                    </div>
                    <div class="mb-2">
                        <label class="block font-medium text-sm text-gray-700">NIK:</label>
                        <input type="text" name="nik" class="form-input rounded-md shadow-sm mt-1 block w-full">
                    </div>
                    <div class="mb-2">
                        <label class="block font-medium text-sm text-gray-700">Alamat:</label>
                        <input type="text" name="alamat" class="form-input rounded-md shadow-sm mt-1 block w-full">
                    </div>
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

                {{-- Form tujuan banjar --}}
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
                        <option value="5">Keluar Desa</option>
                </select>
                </div>

                {{-- Tanggal Mutasi --}}
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Tanggal Mutasi:</label>
                    <input type="date" name="tanggal" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                </div>
                
                {{-- Pilih Banjar --}}
                {{-- <div class="mb-2">
                    <label class="block font-medium text-sm text-gray-700">Banjar:</label>
                    <select name="banjar_id" class="form-select rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="">-- Pilih Banjar --</option>
                        @foreach ($banjar as $b)
                            <option value="{{ $b->id }}">{{ $b->nama }}</option>
                        @endforeach
                    </select>
                </div> --}}

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

{{-- JavaScript untuk toggle form --}}
<script>
    function toggleForm() {
        const value = document.querySelector('input[name="penduduk_terdaftar"]:checked').value;
        document.getElementById('formLama').style.display = (value === "1") ? "block" : "none";
        document.getElementById('formBaru').style.display = (value === "0") ? "block" : "none";
    }

    // Pastikan form tampil sesuai radio saat page dimuat
    window.addEventListener('DOMContentLoaded', toggleForm);
</script>
@endsection
