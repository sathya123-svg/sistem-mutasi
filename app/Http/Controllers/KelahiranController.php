<?php

namespace App\Http\Controllers;

use App\Models\Kelahiran;
use App\Models\Penduduk;
use App\Models\kk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\KelahiranExport;
use Maatwebsite\Excel\Facades\Excel;


class KelahiranController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        if ($user->role === 'superadmin') {
            $kk = KK::with('kepalaKeluargaPenduduk')
                ->orderBy('nomor_kk')
                ->get();
        } else {
            $kk = KK::with('kepalaKeluargaPenduduk')
                ->where('banjar_id', $user->banjar_id)
                ->orderBy('nomor_kk')
                ->get();
        }

        return view('kelahiran.create', compact('kk'));
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $q = $request->query('q');

        $kelahiran = Kelahiran::with(['penduduk', 'kkTujuan'])
            // 🔐 filter role
            ->when($user->role === 'admin', function ($query) use ($user) {
                $query->whereHas('penduduk', function ($q) use ($user) {
                    $q->where('banjar_id', $user->banjar_id);
                });
            })

            // 🔍 SEARCH NAMA / NIK
            ->when($q, function ($query) use ($q) {
                $query->whereHas('penduduk', function ($sub) use ($q) {
                    $sub->where('nama', 'like', "%$q%")
                        ->orWhere('nik', 'like', "%$q%");
                });
            })

            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('kelahiran.index', compact('kelahiran', 'q'));
    }


    // public function index()
    // {
    //     $user = Auth::user();

    //     // default (superadmin)
    //     $jumlahKelahiran = Kelahiran::count();

    //     // kalau admin banjar → filter
    //     if ($user->role === 'admin' && $user->banjar_id) {
    //         $banjarId = $user->banjar_id;

    //         $jumlahKelahiran = Kelahiran::whereHas('penduduk', function ($q) use ($banjarId) {
    //             $q->where('banjar_id', $banjarId);
    //         })->count();
    //     }

    //     return view('dashboard', compact('jumlahKelahiran'));
    // }

        public function store(Request $request)
    {

            if ($request->nik === '-' || $request->nik === '') {
            $request->merge(['nik' => null]);
        }

        $request->validate([
            'nama' => 'required',
            'nik' => 'nullable|unique:penduduk,nik',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required',
            'kk_id' => 'required|exists:kks,id',
        ]);

        DB::transaction(function () use ($request) {

            $kk = KK::findOrFail($request->kk_id);

            
            // 1️⃣ SIMPAN KE PENDUDUK (DATA UTAMA BAYI)
            $penduduk = Penduduk::create([
                'nama' => $request->nama,
                'nik' => $request->nik,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'kewarganegaraan' => $request->kewarganegaraan,
                'kk_id' => $request->kk_id,      // ✅ masuk KK tujuan
                'banjar_id' => $kk->banjar_id,
            ]);

            // 2️⃣ CATAT KE TABEL KELAHIRAN (LOG)
            Kelahiran::create([
                'penduduk_id' => $penduduk->id, // ✅ WAJIB ADA
                'kk_tujuan_id' => $request->kk_id,
                'nik' => $request->nik,
                'jenis_kelamin' => $request->jenis_kelamin,
            ]);
        });

        return back()->with('success', 'Data kelahiran berhasil ditambahkan.');
    }

public function exportExcel(Request $request)
{
    return Excel::download(
        new KelahiranExport($request->user(), $request->q),
        'data_kelahiran.xlsx'
    );
}

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama' => 'required',
    //         'jenis_kelamin' => 'required|in:L,P',
    //         'tanggal_lahir' => 'required|date',
    //         'kk_id' => 'required|exists:kks,id',
    //     ]);

    //     DB::transaction(function() use ($request) {

    //         $kk = kk::find($request->kk_id);

    //         // Tambah penduduk baru
    //         $penduduk = Penduduk::create([
    //             'nama' => $request->nama,
    //             'nik' => $request->nik,
    //             'jenis_kelamin' => $request->jenis_kelamin,
    //             'tempat_lahir' => $request->tempat_lahir,
    //             'alamat' => $request->alamat,
    //             'kewarganegaraan' => $request->kewarganegaraan,
    //             'tanggal_lahir' => $request->tanggal_lahir,
    //             'kk_tujuan_id' => $request->kk_id,
    //             'banjar_id' => $kk->banjar_id,
    //         ]);

    //         // Catat kelahiran
    //         Kelahiran::create([
    //             'penduduk_id' => $penduduk->id,
    //             'kk_tujuan_id' => $request->kk_id,
    //             'tanggal_lahir' => $request->tanggal_lahir,
    //         ]);

    //     });

    //     return back()->with('success', 'Data kelahiran berhasil ditambahkan.');
    // }
}
