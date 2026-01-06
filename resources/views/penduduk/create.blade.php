@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-xl font-bold mb-4">Tambah Penduduk</h1>

    <form action="{{ route('penduduk.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block">Nama</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border p-2">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label>NIK</label>
                    <input type="text" name="nik" value="{{ old('nik') }}" class="w-full border p-2">
                </div>
                <div>
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full border p-2">
                        <option value="L" {{ old('jenis_kelamin')=='L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin')=='P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label>Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="w-full border p-2">
                </div>
                <div>
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full border p-2">
                </div>
            </div>

            <div>
                <label>Alamat</label>
                <textarea name="alamat" class="w-full border p-2">{{ old('alamat') }}</textarea>
            </div>

            <div class="grid grid-cols-3 gap-4">
                {{-- <div>
                    <label>RT</label>
                    <input type="text" name="rt" value="{{ old('rt') }}" class="w-full border p-2">
                </div>
                <div>
                    <label>RW</label>
                    <input type="text" name="rw" value="{{ old('rw') }}" class="w-full border p-2">
                </div> --}}
                <div>
                    <label>Banjar</label>
                    <select name="banjar_id" class="w-full border p-2">
                        <option value="">-- Pilih Banjar --</option>
                        @foreach($banjars as $b)
                            <option value="{{ $b->id }}" {{ old('banjar_id') == $b->id ? 'selected' : '' }}>{{ $b->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            

            {{-- <div class="grid grid-cols-3 gap-4">
                <div>
                    <label>Agama</label>
                    <input type="text" name="agama" value="{{ old('agama') }}" class="w-full border p-2">
                </div>
                <div>
                    <label>Pendidikan</label>
                    <input type="text" name="pendidikan" value="{{ old('pendidikan') }}" class="w-full border p-2">
                </div>
                <div>
                    <label>Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" class="w-full border p-2">
                </div>
            </div> --}}

            <div class="grid grid-cols-3 gap-4">
                {{-- <div>
                    <label>Status Perkawinan</label>
                    <input type="text" name="status_perkawinan" value="{{ old('status_perkawinan') }}" class="w-full border p-2">
                </div>
                <div>
                    <label>Hubungan Keluarga</label>
                    <input type="text" name="hubungan_keluarga" value="{{ old('hubungan_keluarga') }}" class="w-full border p-2" placeholder="Kepala Keluarga/Anak/).
">
                </div> --}}
                <div>
                    <label>Kewarganegaraan</label>
                    <input type="text" name="kewarganegaraan" value="{{ old('kewarganegaraan') }}" class="w-full border p-2">
                </div>
            </div>

            <div>
                <label>Pilih Nomor KK (opsional)</label>
                <select name="kk_id" class="w-full border p-2">
                    <option value="">-- Tidak dimasukkan ke KK sekarang --</option>
                    @foreach($kks as $kk)
                        <option value="{{ $kk->id }}" {{ old('kk_id') == $kk->id ? 'selected' : '' }}>
                            {{ $kk->nomor_kk }} - {{ $kk->kepalaKeluargaPenduduk->nama ?? ' - ' }}
                        </option>
                    @endforeach
                </select>
                <small class="text-gray-500">Jika tidak memilih, penduduk akan berdiri sendiri (belum di KK).</small>
            </div>

            {{-- tombol --}}
            <div class="flex gap-4">
                <button
                type="submit"
                style="
                    background:#dc2626 !important;
                    color:#fff !important;
                    padding:8px 16px !important;
                    border:none !important;
                    border-radius:6px !important;
                    font-weight:600 !important;
                    cursor:pointer !important;
                ">
                Simpan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
