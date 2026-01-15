<?php

namespace App\Http\Controllers;

use App\Models\Kematian;
use App\Models\Penduduk;
use App\Models\KK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\KematianExport;
use Maatwebsite\Excel\Facades\Excel;



class KematianController extends Controller
{
    public function create()
    {
        // menampilkan daftar penduduk untuk dipilih
        $penduduk = Penduduk::orderBy('nama')->get();

        return view('kematian.create', compact('penduduk'));
    }

    public function index()
    {
        $kematian = Kematian::with('penduduk')->latest()->get();
        return view('kematian.index', compact('kematian'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'penduduk_id' => 'required|exists:penduduk,id',
            'nomor_kk' => 'required|string',
            'tanggal_kematian' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        // ===============================
        // 🔒 CEK KEPALA KELUARGA
        // ===============================
        $penduduk = Penduduk::findOrFail($request->penduduk_id);

        $isKepalaKeluarga = KK::where('kepala_keluarga', $penduduk->id)->exists();

        if ($isKepalaKeluarga) {
            return back()->withErrors([
                'penduduk_id' => 'Penduduk ini adalah Kepala Keluarga. Silakan ganti Kepala Keluarga terlebih dahulu.'
            ])->withInput();
        }
        // ===============================

        DB::transaction(function () use ($request, $penduduk) {

            $penduduk->load('kk');

            // Catat data kematian
            Kematian::create([
                'penduduk_id' => $penduduk->id,
                'nik' => $penduduk->nik,
                'nama' => $penduduk->nama,
                'nomor_kk' => $penduduk->kk->nomor_kk ?? null,
                'banjar_id' => $penduduk->banjar_id,
                'keterangan' => $request->keterangan,
                'tanggal_kematian' => $request->tanggal_kematian,
            ]);

            // Hapus penduduk dari data aktif
            $penduduk->delete();
        });

        return redirect()
            ->route('kematian.create')
            ->with('success', 'Data kematian berhasil dicatat.');
    }

    public function exportExcel(Request $request)
{
    return Excel::download(
        new KematianExport($request->user(), $request->q),
        'data_kematian.xlsx'
    );
}
}
