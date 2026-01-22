<?php

namespace App\Http\Controllers;

use App\Models\Perkawinan;
use App\Models\Penduduk;
use App\Models\KK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\perkawinanExport;
use Maatwebsite\Excel\Facades\Excel;



class PerkawinanController extends Controller
{
    // =============================
    // Form tambah perkawinan
    // =============================
    public function create()
    {
        $user = Auth::user();

        if ($user->role === 'superadmin') {
            $penduduk = Penduduk::orderBy('nama')->get();
            $kk = KK::with('kepalaKeluargaPenduduk')->get();
        } else {
            $penduduk = Penduduk::where('banjar_id', $user->banjar_id)
                ->orderBy('nama')
                ->get();

            $kk = KK::with('kepalaKeluargaPenduduk')
                ->where('banjar_id', $user->banjar_id)
                ->get();
        }

        return view('perkawinan.create', compact('penduduk', 'kk'));
    }


        public function index()
        {
            $user = Auth::user();

            if ($user->role === 'superadmin') {
                $perkawinan = Perkawinan::latest()->get();
            } else {
                $perkawinan = Perkawinan::where('banjar_id', $user->banjar_id)
                    ->latest()
                    ->get();
            }

            return view('perkawinan.index', compact('perkawinan'));
        }



    // =============================
    // Simpan data perkawinan
    // =============================
    public function store(Request $request)
    {
        $request->validate([
            'penduduk_id'   => 'required|exists:penduduk,id',
            'tipe'          => 'required|in:masuk,keluar',
            'tanggal'       => 'required|date',
            'kk_tujuan_id'  => 'required_if:tipe,masuk|nullable|exists:kks,id',
            'keterangan'    => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {

            $penduduk = Penduduk::findOrFail($request->penduduk_id);

            // =========================
            // JIKA MENIKAH MASUK
            // =========================
            if ($request->tipe === 'masuk') {
                $kk = KK::findOrFail($request->kk_tujuan_id);

                $penduduk->update([
                    'kk_id' => $kk->id,
                    'banjar_id' => $kk->banjar_id,
                ]);
            }

            // =========================
            // CATAT PERKAWINAN (WAJIB SEBELUM DELETE)
            // =========================
            Perkawinan::create([
                'penduduk_id'  => $penduduk->id,
                'nama'         => $penduduk->nama,
                'nik'          => $penduduk->nik,
                'nomor_kk'     => $penduduk->kk->nomor_kk ?? null,
                'banjar_id'    => $penduduk->banjar_id,

                // 🔥 INI YANG PENTING
                'tipe'  => $request->tipe, // masuk / keluar
                'kk_tujuan_id' => $request->tipe === 'masuk'
                                    ? $request->kk_tujuan_id
                                    : null,

                'tanggal'      => $request->tanggal,
                'keterangan'   => $request->keterangan,
            ]);

            // =========================
            // JIKA MENIKAH KELUAR → HAPUS
            // =========================
            if ($request->tipe === 'keluar') {
                $penduduk->delete();
            }
        });


        return redirect()
            ->route('perkawinan.create')
            ->with('success', 'Data perkawinan berhasil disimpan.');
    }

        public function exportExcel()
    {
        return Excel::download(
            new perkawinanExport(),
            'data_perkawinan.xlsx'
        );
    }
}   
