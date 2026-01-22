<?php

namespace App\Http\Controllers;

use App\Models\MutasiKeluar;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MutasiKeluarController extends Controller
{
    /**
     * Display a listing of mutasi keluar.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'superadmin') {
            // Superadmin lihat semua
            $data = MutasiKeluar::latest()->get();
        } else {
            // Admin banjar hanya lihat banjarnya
            $data = MutasiKeluar::where('banjar_id', $user->banjar_id)
                ->latest()
                ->get();
        }

        return view('mutasi_keluar.index', compact('data'));
    }

    /**
     * Show the form for creating a new mutasi keluar.
     */
    public function create()
    {
        $user = Auth::user();

        // Superadmin bisa lihat semua penduduk
        if ($user->role === 'superadmin') {
            $penduduk = Penduduk::orderBy('nama')->get();
        } 
        // Operator hanya penduduk banjar masing-masing
        else {
            $penduduk = Penduduk::where('banjar_id', $user->banjar_id)
                ->orderBy('nama')
                ->get();
        }

        return view('mutasi_keluar.create', compact('penduduk'));
    }

    /**
     * Store a newly created mutasi keluar in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'penduduk_id'     => 'required|exists:penduduk,id',
            'tanggal_keluar'  => 'required|date',
            'alasan'          => 'required|string|max:255',
            'tujuan_daerah'   => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {

            $penduduk = Penduduk::with('kk')->findOrFail($request->penduduk_id);

            // Simpan SNAPSHOT data (histori)
            MutasiKeluar::create([
                'nama'           => $penduduk->nama,
                'nik'            => $penduduk->nik,
                'nomor_kk'       => $penduduk->kk->nomor_kk ?? null,
                'tanggal_keluar' => $request->tanggal_keluar,
                'alasan'         => $request->alasan,
                'tujuan_daerah'  => $request->tujuan_daerah,
                'banjar_id'      => $penduduk->banjar_id,
            ]);

            // 🔥 Hapus dari penduduk aktif
            $penduduk->delete();
        });

        return redirect()
            ->route('mutasi_keluar.index')
            ->with('success', 'Data mutasi keluar berhasil dicatat.');
    }

    /**
     * Show the specified resource.
     * (opsional, kalau belum dipakai boleh dikosongkan)
     */
    public function show($id)
    {
        $mutasi = MutasiKeluar::findOrFail($id);
        return view('mutasi_keluar.show', compact('mutasi'));
    }

    /**
     * Remove the specified resource from storage.
     * (biasanya jarang dipakai untuk histori, tapi tetap disiapkan)
     */
    public function destroy($id)
    {
        $mutasi = MutasiKeluar::findOrFail($id);
        $mutasi->delete();

        return redirect()
            ->route('mutasi_keluar.index')
            ->with('success', 'Data mutasi keluar berhasil dihapus.');
    }
}
