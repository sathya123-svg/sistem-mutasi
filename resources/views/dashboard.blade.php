@extends('layouts.app')

@section('content')
<!-- ====== STYLE ====== -->
<style>
    .dashboard-container {
        padding: 2rem;
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border-radius: 20px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(99, 102, 241, 0.3);
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-6px);
    }

    .stat-card h3 {
        font-size: 2rem;
        font-weight: 700;
    }

    .stat-card p {
        margin-top: 0.5rem;
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .chart-container {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .quick-links {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 2rem;
    }

    .quick-links a {
        flex: 1;
        min-width: 180px;
        background: #f8fafc;
        border-radius: 12px;
        padding: 1rem;
        text-align: center;
        color: #1f2937;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s;
        border: 1px solid transparent;
    }

    .quick-links a:hover {
        background: #eef2ff;
        border-color: #6366f1;
        color: #4338ca;
        transform: translateY(-3px);
    }
</style>

<!-- ====== CONTENT ====== -->
<div class="dashboard-container">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Dashboard Sistem Mutasi Penduduk
    </h1>

    <!-- Statistik Cards -->
    <div class="stat-grid">
        <div class="stat-card">
            <h3>{{ number_format($totalPenduduk) }}</h3>
            <p>Total Penduduk</p>
        </div>
        <a href="{{ route('mutasi.masuk') }}">
            <div class="stat-card" style="background: linear-gradient(135deg, #3deb5d, #0cab29);">
                <h3>{{ $mutasiMasuk }}</h3>
                <p>Mutasi Masuk</p>
                <small>Kelahiran & Pendatang</small>
            </div>
        </a>

        <a href="{{ route('mutasi.keluar') }}">
            <div class="stat-card" style="background: linear-gradient(135deg, #ef4444, #b91c1c);">
                <h3>{{ $mutasiKeluar }}</h3>
                <p>Mutasi Keluar</p>
                <small>Kematian & Perkawinan</small>
            </div>
        </a>

        <div class="stat-card" style="background: linear-gradient(135deg, #3b82f6, #1e40af);">
            <h3>{{ $jumlahBanjar }}</h3>
            <p>Jumlah Banjar</p>
        </div>
    </div>

    <!-- Chart -->
    {{-- <div class="chart-container mt-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Statistik Mutasi Bulanan</h2>
        <canvas id="mutasiChart" height="100"></canvas>
    </div> --}}

    <!-- Akses Cepat -->
<h2 class="text-xl font-semibold mt-10 mb-4">Akses Cepat</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

    <!-- Kelahiran -->
    <a href="{{ route('kelahiran.create') }}" 
        class="p-6 bg-white shadow rounded-xl hover:shadow-lg transition flex items-center space-x-4 border hover:border-blue-400">
        <div class="p-3 bg-blue-100 rounded-full">
            <i class="fas fa-baby text-blue-600 text-2xl"></i>
        </div>
        <div>
            <h3 class="text-lg font-bold">Kelahiran</h3>
            <p class="text-sm text-gray-600">Tambah data kelahiran</p>
        </div>
    </a>

    <!-- Kematian -->
    <a href="{{ route('kematian.create') }}" 
        class="p-6 bg-white shadow rounded-xl hover:shadow-lg transition flex items-center space-x-4 border hover:border-red-400">
        <div class="p-3 bg-red-100 rounded-full">
            <i class="fas fa-cross text-red-600 text-2xl"></i>
        </div>
        <div>
            <h3 class="text-lg font-bold">Kematian</h3>
            <p class="text-sm text-gray-600">Input data kematian</p>
        </div>
    </a>

    <!-- Pendatang -->
    <a href="{{ route('pendatang.create') }}" 
        class="p-6 bg-white shadow rounded-xl hover:shadow-lg transition flex items-center space-x-4 border hover:border-green-400">
        <div class="p-3 bg-green-100 rounded-full">
            <i class="fas fa-user-plus text-green-600 text-2xl"></i>
        </div>
        <div>
            <h3 class="text-lg font-bold">Pendatang</h3>
            <p class="text-sm text-gray-600">Data pendatang masuk</p>
        </div>
    </a>

    <!-- Perkawinan -->
    <a href="{{ route('perkawinan.create') }}" 
        class="p-6 bg-white shadow rounded-xl hover:shadow-lg transition flex items-center space-x-4 border hover:border-purple-400">
        <div class="p-3 bg-purple-100 rounded-full">
            <i class="fas fa-ring text-purple-600 text-2xl"></i>
        </div>
        <div>
            <h3 class="text-lg font-bold">Perkawinan</h3>
            <p class="text-sm text-gray-600">Catat data perkawinan</p>
        </div>
    </a>

        <!-- Import Data Penduduk -->
    <a href="{{ route('penduduk.import.form') }}" 
        class="p-6 bg-white shadow rounded-xl hover:shadow-lg transition flex items-center space-x-4 border hover:border-indigo-400">
        <div class="p-3 bg-indigo-100 rounded-full">
            <i class="fas fa-file-import text-indigo-600 text-2xl"></i>
        </div>
        <div>
            <h3 class="text-lg font-bold">Import Data</h3>
            <p class="text-sm text-gray-600">Unggah file Excel Penduduk</p>
        </div>
    </a>

    <!-- Export Data Penduduk -->
    <a href="{{ route('penduduk.export.excel') }}" 
        class="p-6 bg-white shadow rounded-xl hover:shadow-lg transition 
        flex items-center space-x-4 border hover:border-teal-400">
        <div class="p-3 bg-teal-100 rounded-full">
            <i class="fas fa-file-export text-teal-600 text-2xl"></i>
        </div>
        <div>
            <h3 class="text-lg font-bold">Export Data</h3>
            <p class="text-sm text-gray-600">Download Excel Penduduk</p>
        </div>
    </a>




</div>


<!-- ====== SCRIPTS ====== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('mutasiChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt'],
            datasets: [
                {
                    label: 'Mutasi Masuk',
                    data: [12, 19, 8, 17, 14, 20, 13, 9, 15, 11],
                    backgroundColor: '#10b981',
                    borderRadius: 6
                },
                {
                    label: 'Mutasi Keluar',
                    data: [5, 9, 4, 8, 6, 10, 7, 4, 9, 5],
                    backgroundColor: '#ef4444',
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: { color: '#374151' }
                }
            },
            scales: {
                x: { ticks: { color: '#6b7280' } },
                y: { ticks: { color: '#6b7280' } }
            }
        }
    });
</script>
@endsection










{{-- @extends('layouts.app') <!-- sesuaikan dengan layout kamu -->

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
{{-- </div>
@endsection --}}




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
