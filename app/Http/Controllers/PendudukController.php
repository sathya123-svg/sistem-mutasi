<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendudukController extends Controller
{
    public function index()
    {
            $user = Auth::user();

    if ($user->role === 'admin') {
        $penduduk = Penduduk::with('banjar')->latest()->get();
    } else {
        $penduduk = Penduduk::where('banjar_id', $user->banjar_id)->latest()->get();
    }

    return view('penduduk.index', compact('penduduk'));
    }

    public function create()
    {
        return view('penduduk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:penduduk,nik',
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'banjar_id' => 'required|exists:banjar,id',
        ]);

        $user = Auth::user();

        Penduduk::create([
            'nik' => $request->input('nik'),
            'nama' => $request->input('nama'),
            'alamat' => $request->input('alamat'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'banjar_id' => $user->role === 'admin' ? $request->input('banjar_id') : $user->banjar_id,
        ]);

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function edit(Penduduk $penduduk)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $user->banjar_id !== $penduduk->banjar_id) {
            abort(403);
        }

        return view('penduduk.edit', compact('penduduk'));
    }

    public function update(Request $request, Penduduk $penduduk)
    {
        $request->validate([
            'nik' => 'required|unique:penduduk,nik,' . $penduduk->id,
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
        ]);

        $user = Auth::user();

        if ($user->role !== 'admin' && $user->banjar_id !== $penduduk->banjar_id) {
            abort(403);
        }

        $penduduk->update([
            'nik' => $request->input('nik'),
            'nama' => $request->input('nama'),
            'alamat' => $request->input('alamat'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
        ]);

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil diperbarui.');
    }

    public function destroy(Penduduk $penduduk)
    {
        $user = Auth::user();

        if ($user->role !== 'admin' && $user->banjar_id !== $penduduk->banjar_id) {
            abort(403);
        }

        $penduduk->delete();

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil dihapus.');
    }

    public function show($id)
    {
    $penduduk = Penduduk::with('mutasi')->findOrFail($id);
    return view('penduduk.show', compact('penduduk'));
    }

}
