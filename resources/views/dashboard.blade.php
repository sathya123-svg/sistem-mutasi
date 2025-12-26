@extends('layouts.app') <!-- sesuaikan dengan layout kamu -->

@section('content')
<style>
    .menu-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 2rem;
        margin-top: 2rem;
    }

    .menu-card {
        width: 200px;
        height: 200px;
        background-color: #f1f5f9;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        text-decoration: none;
        color: #1f2937;
        transition: all 0.3s ease;
    }

    .menu-card:hover {
        background-color: #e2e8f0;
        transform: translateY(-5px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.15);
    }

    .menu-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #0f172a;
    }

    .menu-title {
        font-size: 1.2rem;
        font-weight: bold;
    }
</style>

<div class="menu-container">
    <a href="{{ route('penduduk.create') }}" class="menu-card">
        <div class="menu-icon">👥</div>
        <div class="menu-title">Pencatatan Penduduk</div>
    </a>

    
    <a href="{{ route('penduduk.index') }}" class="menu-card">
        <div class="menu-icon">📋</div>
        <div class="menu-title">Data Penduduk</div>
    </a>

    <a href="{{ route('mutasi.create') }}" class="menu-card">
        <div class="menu-icon">🔄</div>
        <div class="menu-title">Mutasi Penduduk</div>
    </a>

    <a href="{{ route('mutasi.index') }}" class="menu-card">
        <div class="menu-icon">📊</div>
        <div class="menu-title">Laporan Mutasi</div>
    </a>

       <a href="{{ route('penduduk.import.form') }}" class="menu-card">
        <div class="menu-icon">📋</div>
        <div class="menu-title">Import Data</div>
    </a>
    {{-- Tambahkan menu lainnya di sini --}}
</div>
@endsection




{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Menu: Input Data Penduduk -->
                <a href="{{ route('penduduk.create') }}" class="p-6 bg-white rounded-xl shadow hover:shadow-md transition duration-300 border hover:bg-blue-50">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-blue-100 rounded-full">
                            <!-- Ikon Tambah -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Input Data Penduduk</h3>
                            <p class="text-sm text-gray-600">Formulir untuk menambahkan penduduk baru</p>
                        </div>
                    </div>
                </a>

                <!-- Menu: Lihat Data Penduduk -->
                <a href="{{ route('penduduk.index') }}" class="p-6 bg-white rounded-xl shadow hover:shadow-md transition duration-300 border hover:bg-green-50">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-green-100 rounded-full">
                            <!-- Ikon Daftar -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Data Penduduk</h3>
                            <p class="text-sm text-gray-600">Lihat dan kelola data penduduk</p>
                        </div>
                    </div>
                </a>

                <!-- Menu: Laporan -->
                <a href="#" class="p-6 bg-white rounded-xl shadow hover:shadow-md transition duration-300 border hover:bg-yellow-50">
                    <div class="flex items-center space-x-4">
                        <div class="p-3 bg-yellow-100 rounded-full">
                            <!-- Ikon Laporan -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h13v6M4 6h16M4 10h16M4 14h4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Laporan</h3>
                            <p class="text-sm text-gray-600">Lihat laporan data penduduk</p>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
</x-app-layout> --}}

















{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard - Input Data Penduduk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="mb-4 font-medium text-sm text-green-600">
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
                        <label class="block font-medium text-sm text-gray-700">Banjar:</label>
                        <select name="banjar" class="form-select rounded-md shadow-sm mt-1 block w-full" required>
                            <option value="">-- Pilih Banjar --</option>
                            <option value="Kangin">Kangin</option>
                            <option value="Kauh">Kauh</option>
                            <option value="Kelod">Kelod</option>
                            <option value="Kaja">Kaja</option>
                        </select>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Simpan Data
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout> --}}






{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}
