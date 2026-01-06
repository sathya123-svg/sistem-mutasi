<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\Kelahiran;
use App\Models\Kematian;
use App\Models\Pendatang;
use App\Models\Perkawinan;
use App\Models\Banjar;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // ======================
        // SUPER ADMIN
        // ======================
        if ($user->role === 'superadmin') {

            $mutasiMasuk =
                Kelahiran::count() +
                Pendatang::count() + 
                Perkawinan::where('tipe', 'masuk')->count();

            $mutasiKeluar =
                Kematian::count() +
                Perkawinan::where('tipe', 'keluar')->count();
            return view('dashboard', [
                'totalPenduduk' => Penduduk::count(),
                'mutasiMasuk'   => $mutasiMasuk,
                'mutasiKeluar'  => $mutasiKeluar,
                'jumlahBanjar'  => Banjar::count(),
            ]);
        }

        // ======================
        // ADMIN BANJAR
        // ======================
if ($user->role === 'admin') {

    $banjar_id = $user->banjar_id;

    $mutasiMasuk =
        Kelahiran::whereHas('penduduk', function ($q) use ($banjar_id) {
            $q->where('banjar_id', $banjar_id);
        })->count()
        +
        Pendatang::whereHas('penduduk', function ($q) use ($banjar_id) {
            $q->where('banjar_id', $banjar_id);
        })->count()
        +
        Perkawinan::where('tipe', 'masuk')
            ->whereHas('penduduk', function ($q) use ($banjar_id) {
                $q->where('banjar_id', $banjar_id);
            })->count();

    $mutasiKeluar =
        Kematian::whereHas('penduduk', function ($q) use ($banjar_id) {
            $q->where('banjar_id', $banjar_id);
        })->count()
        +
        Perkawinan::where('tipe', 'keluar')
            ->whereHas('penduduk', function ($q) use ($banjar_id) {
                $q->where('banjar_id', $banjar_id);
            })->count();

    return view('dashboard', [
        'totalPenduduk' => Penduduk::where('banjar_id', $banjar_id)->count(),
        'mutasiMasuk'   => $mutasiMasuk,
        'mutasiKeluar'  => $mutasiKeluar,
        'jumlahBanjar'  => Banjar::count(),
    ]);
}


        abort(403, 'Role tidak dikenali');
    }

    // ======================
// DETAIL MUTASI MASUK
// (Kelahiran + Pendatang)
// ======================
    public function mutasiMasuk(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'superadmin') {
            $kelahiran = Kelahiran::latest()->get();
            $pendatang = Pendatang::latest()->get();
            $perkawinan = Perkawinan::where('tipe', 'masuk')->latest()->get();
        } else {
        $kelahiran = Kelahiran::whereHas('penduduk', function ($q) use ($user) {
            $q->where('banjar_id', $user->banjar_id);
        })->latest()->get();

        $pendatang = Pendatang::whereHas('penduduk', function ($q) use ($user) {
            $q->where('banjar_id', $user->banjar_id);
        })->latest()->get();

        $perkawinan = Perkawinan::where('tipe', 'masuk')
            ->whereHas('penduduk', function ($q) use ($user) {
                $q->where('banjar_id', $user->banjar_id);
            })->latest()->get();
        }

        return view('mutasi.masuk', compact('kelahiran', 'pendatang'));
    }

    // ======================
    // DETAIL MUTASI KELUAR
    // (Kematian + Perkawinan)
    // ======================
    public function mutasiKeluar(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'superadmin') {
            $kematian = Kematian::latest()->get();
            $perkawinan = Perkawinan::where('tipe', 'keluar')->latest()->get();
        } else {
        $kematian = Kematian::whereHas('penduduk', function ($q) use ($user) {
            $q->where('banjar_id', $user->banjar_id);
        })->latest()->get();

        $perkawinan = Perkawinan::where('tipe', 'keluar')
            ->whereHas('penduduk', function ($q) use ($user) {
                $q->where('banjar_id', $user->banjar_id);
            })->latest()->get();
        }

        return view('mutasi.keluar', compact('kematian', 'perkawinan'));
    }

    }


// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Penduduk;
// use App\Models\Kelahiran;
// use App\Models\Kematian;
// use App\Models\Pendatang;
// use App\Models\Perkawinan;

// class DashboardController extends Controller
// {
//     public function index(Request $request)
//     {
//         $user = $request->user();

//         // Jika pengguna adalah Super Admin (lihat semua data)
//         if ($user->role === 'superadmin') {

//             $data = [
//                 'totalPenduduk' => Penduduk::count(),
//                 'totalKelahiran' => Kelahiran::count(),
//                 'totalKematian' => Kematian::count(),
//                 'totalPendatang' => Pendatang::count(),
//                 'totalPerkawinan' => Perkawinan::count(),
//             ];

//             return view('dashboard', $data);
//         }

//         // Jika Admin banjar (hanya data banjarnya)
//         if ($user->role === 'admin') {

//             $banjar_id = $user->banjar_id;

//             $data = [
//                 'totalPenduduk' => Penduduk::where('banjar_id', $banjar_id)->count(),
//                 'totalKelahiran' => Kelahiran::where('banjar_id', $banjar_id)->count(),
//                 'totalKematian' => Kematian::where('banjar_id', $banjar_id)->count(),
//                 'totalPendatang' => Pendatang::where('banjar_id', $banjar_id)->count(),
//                 'totalPerkawinan' => Perkawinan::where('banjar_id', $banjar_id)->count(),
//             ];

//             return view('dashboard', $data);
//         }

//         return abort(403, 'Role tidak dikenali');
//     }
    
// }
