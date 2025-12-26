@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Penduduk</h1>

    <form action="{{ route('penduduk.update', $penduduk->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>NIK</label>
            <input type="text" name="nik" class="form-control" value="{{ $penduduk->nik }}" required>
        </div>
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $penduduk->nama }}" required>
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required>{{ $penduduk->alamat }}</textarea>
        </div>
        <div class="mb-3">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="L" {{ $penduduk->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $penduduk->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" value="{{ $penduduk->tanggal_lahir }}" required>
        </div>

        <button type="submit" class="btn btn-success">Perbarui</button>
    </form>
</div>
@endsection
