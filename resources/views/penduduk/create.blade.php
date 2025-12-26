@extends('layouts.app')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="mb-4 text-sm text-green-600">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('penduduk.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Nama:</label>
                        <input type="text" name="nama" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">NIK:</label>
                        <input type="text" name="nik" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Alamat:</label>
                        <input type="text" name="alamat" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Jenis Kelamin:</label>
                        <select name="jenis_kelamin" class="form-select rounded-md shadow-sm mt-1 block w-full" required>
                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Tanggal Lahir:</label>
                        <input type="date" name="tanggal_lahir" class="form-input rounded-md shadow-sm mt-1 block w-full" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Banjar:</label>
                        <select name="banjar_id" class="form-select rounded-md shadow-sm mt-1 block w-full" required>
                            <option value="">-- Pilih Banjar --</option>
                            <option value="1">Kangin</option>
                            <option value="2">Kauh</option>
                            <option value="3">Kelod</option>
                            <option value="4">Kaja</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
<button type="submit" 
    class="px-4 py-2 bg-blue-500 text-black rounded hover:bg-blue-600 focus:outline-none">
    Submit
</button>


                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection





{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Penduduk</h1>

    <form action="{{ route('penduduk.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>NIK</label>
            <input type="text" name="nik" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" required>
        </div>
        @if (Auth::user()->role === 'admin')
        <div class="mb-3">
            <label>Banjar</label>
            <select name="banjar_id" class="form-control" required>
                @foreach (App\Models\Banjar::all() as $banjar)
                    <option value="{{ $banjar->id }}">{{ $banjar->nama }}</option>
                @endforeach
            </select>
        </div>
        @endif

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection --}}
