<?php

namespace App\Http\Controllers;

use App\Models\Pendatang;
use App\Models\Penduduk;
use App\Models\KK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\pendatangExport;
use Maatwebsite\Excel\Facades\Excel;



class PendatangController extends Controller
{


    /**
     * Form tambah pendatang
     */
    public function create()
    {
        $user = Auth::user();

        // SUPER ADMIN → semua KK
        if ($user->role === 'superadmin') {
            $kk = KK::with('kepalaKeluargaPenduduk')
                ->orderBy('nomor_kk')
                ->get();
        } 
        // ADMIN BANJAR → hanya KK banjarnya
        else {
            $kk = KK::with('kepalaKeluargaPenduduk')
                ->where('banjar_id', $user->banjar_id)
                ->orderBy('nomor_kk')
                ->get();
        }

        return view('pendatang.create', compact('kk'));
    }




    /**
     * List pendatang
     */
    public function index()
    {
        $pendatang = Pendatang::with(['penduduk', 'kkTujuan'])->get();
        return view('pendatang.index', compact('pendatang'));
    }


    /**
     * Simpan pendatang
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'nik'           => 'required|string|max:20|unique:penduduk,nik',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir'  => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'asal'          => 'required|string|max:255',
            'kk_tujuan_id'  => 'required|exists:kks,id',
        ]);

        DB::transaction(function () use ($request) {

            $kk = KK::findOrFail($request->kk_tujuan_id);

            // 1️⃣ INSERT ke penduduk (WAJIB LENGKAP)
            $penduduk = Penduduk::create([
                'nama'             => $request->nama,
                'nik'              => $request->nik,
                'jenis_kelamin'    => $request->jenis_kelamin,
                'tempat_lahir'     => $request->tempat_lahir,
                'tanggal_lahir'    => $request->tanggal_lahir,
                'kk_id'            => $kk->id,
                'banjar_id'        => $kk->banjar_id,
                'kewarganegaraan'  => 'Indonesia',
            ]);

            // 2️⃣ INSERT ke pendatang (CATATAN)
            Pendatang::create([
                'penduduk_id'  => $penduduk->id,
                'asal'         => $request->asal,
                'kk_tujuan_id' => $kk->id,
                'banjar_id'    => $kk->banjar_id,
            ]);
        });

        return redirect()
            ->route('pendatang.index')
            ->with('success', 'Pendatang berhasil ditambahkan');
    }

        public function exportExcel()
    {
        return Excel::download(
            new PendatangExport(),
            'data_pendatang.xlsx'
        );
    }

}
