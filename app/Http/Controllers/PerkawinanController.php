<?php

namespace App\Http\Controllers;

use App\Models\Perkawinan;
use App\Models\Penduduk;
use App\Models\KK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\PerkawinanExport;
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
        $perkawinan = Perkawinan::latest()->get();
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

            // Jika MASUK KK
            if ($request->tipe === 'masuk') {
                $kk = KK::findOrFail($request->kk_tujuan_id);
                $penduduk->kk_id = $kk->id;
                $penduduk->banjar_id = $kk->banjar_id;
            }

            // Jika KELUAR KK
            if ($request->tipe === 'keluar') {
                $penduduk->kk_id = null;
            }

            $penduduk->save();

            // Catat perkawinan
            Perkawinan::create([
                'penduduk_id'  => $penduduk->id,
                'kk_tujuan_id' => $request->tipe === 'masuk' ? $request->kk_tujuan_id : null,
                'tipe'         => $request->tipe,
                'tanggal'      => $request->tanggal,
                'keterangan'   => $request->keterangan,
            ]);
        });

        return redirect()
            ->route('perkawinan.create')
            ->with('success', 'Data perkawinan berhasil disimpan.');
    }

        public function exportExcel()
    {
        return Excel::download(
            new PerkawinanExport(),
            'data_perkawinan.xlsx'
        );
    }
}
