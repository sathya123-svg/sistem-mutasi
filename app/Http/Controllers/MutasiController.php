<?php

namespace App\Http\Controllers;
use App\Models\Penduduk;
use App\Models\Mutasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Banjar;

class MutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mutasi = Mutasi::with('penduduk')->get();
     return view('mutasi.index', compact('mutasi'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penduduk = Penduduk::all(); 
        $banjar = Banjar::all();
    return view('mutasi.create', compact('penduduk', 'banjar'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'penduduk_terdaftar' => 'required|in:0,1',
        'nama' => 'required_if:penduduk_terdaftar,0',
        'nik' => 'required_if:penduduk_terdaftar,0|nullable|unique:penduduk,nik',
        'alamat' => 'required_if:penduduk_terdaftar,0',
        'penduduk_id' => 'required_if:penduduk_terdaftar,1|exists:penduduk,id',
        'tujuan_banjar' => 'required|integer',
        'jenis_mutasi' => 'required',
        'tanggal' => 'required|date',
    ]);
    if ($request->penduduk_terdaftar === '1') {
        $pendudukId = $request->penduduk_id;
    } else {
        $pendudukBaru = Penduduk::create([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'alamat' => $request->alamat,
            'banjar_id' => Auth::user()->banjar_id,
            // tambahkan field lain sesuai tabel penduduk
        ]);
        $pendudukId = $pendudukBaru->id;
    }

    Mutasi::create([
        'penduduk_id' => $pendudukId,
        'asal_banjar' => Auth::user()->banjar_id,
        'tujuan_banjar' => $request->tujuan_banjar,
        'jenis_mutasi' => $request->jenis_mutasi,
        'tanggal' => $request->tanggal,
        'keterangan' => $request->keterangan
    ]);

         $penduduk = Penduduk::findOrFail($pendudukId);

             if ($request->jenis_mutasi === 'Pindah Domisili') {
        // Update banjar penduduk
        $penduduk->banjar_id = $request->tujuan_banjar;
        $penduduk->save();
    } 
    elseif ($request->jenis_mutasi === 'Kawin Keluar') {
        // Hapus penduduk dari sistem
        $penduduk->delete();
    }
    elseif ($request->jenis_mutasi === 'Meninggal') {
        // Opsional: bisa hapus atau update status menjadi 'meninggal'
        $penduduk->delete();
    }

    return redirect()->route('mutasi.index')->with('success', 'Data mutasi berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
