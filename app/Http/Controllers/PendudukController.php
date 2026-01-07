<?php

namespace App\Http\Controllers;

use App\Models\Penduduk;
use App\Models\KK;
use App\Models\Banjar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Exports\DataExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

    class PendudukController extends Controller
    {

        public function exportExcel()
    {
        return Excel::download(new DataExport, 'data_penduduk.xlsx');
    }




public function index(Request $request)
{
    $user   = Auth::user();
    $search = $request->search;

    // 🔹 Query dasar
    $query = Penduduk::with('kk', 'banjar');

    // 🔐 ROLE FILTER (INI WAJIB DI ATAS)
    if ($user->role !== 'superadmin') {
        $query->where('banjar_id', $user->banjar_id);
    }

    // 🔍 SEARCH
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhereHas('kk', function ($kk) use ($search) {
                  $kk->where('nomor_kk', 'like', "%{$search}%"); // sesuaikan kolom
              });
        });
    }

    // 🔽 PAGINATION
    $penduduk = $query->orderBy('nama')->paginate(25);
    $penduduk->appends($request->all());

    return view('penduduk.index', compact('penduduk'));
}





    // public function index()
    // {
    //     $user = Auth::user();

    //     // SUPER ADMIN → lihat semua
    //     if ($user->role === 'superadmin') {
    //         $penduduk = Penduduk::with('kk', 'banjar')
    //             ->orderBy('nama')
    //             ->paginate(25);
    //     } 
    //     // ADMIN BANJAR → hanya data banjarnya
    //     else {
    //         $penduduk = Penduduk::with('kk', 'banjar')
    //             ->where('banjar_id', $user->banjar_id)
    //             ->orderBy('nama')
    //             ->paginate(25);
    //     }

    //     return view('penduduk.index', compact('penduduk'));
    // }

    

    public function create()
    {
        $user = Auth::user();

        // SUPER ADMIN
        if ($user->role === 'superadmin') {
            $banjars = Banjar::orderBy('nama')->get();
            $kks = KK::orderBy('nomor_kk')->get();
        }
        // ADMIN BANJAR
        else {
            $banjars = Banjar::where('id', $user->banjar_id)->get();
            $kks = KK::where('banjar_id', $user->banjar_id)->orderBy('nomor_kk')->get();
        }

        return view('penduduk.create', compact('kks', 'banjars'));
    }


    public function store(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'nama' => 'required|string|max:191',
            'nik' => 'nullable|string|unique:penduduk,nik',
            'jenis_kelamin' => ['required', Rule::in(['L','P','l','p','Laki-laki','Perempuan'])],
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:191',
            'alamat' => 'nullable|string',
            'kk_id' => 'nullable|exists:kks,id',
            'kewarganegaraan' => 'nullable|string|max:50',
        ]);

        // Standarisasi JK
        $data['jenis_kelamin'] = strtoupper(substr($data['jenis_kelamin'], 0, 1)) === 'L' ? 'L' : 'P';

        // 🔐 TENTUKAN BANJAR BERDASARKAN ROLE
        if ($user->role === 'superadmin') {
            $data['banjar_id'] = $request->banjar_id;
        } else {
            $data['banjar_id'] = $user->banjar_id;
        }

        $penduduk = Penduduk::create($data);

        return redirect()
            ->route('penduduk.index')
            ->with('success', 'Penduduk berhasil ditambahkan.');
    }


    public function show($id)
    {

        $penduduk = Penduduk::with('kk','banjar')->findOrFail($id);
        return view('penduduk.show', compact('penduduk'));
    }

    public function edit($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $kks = KK::orderBy('nomor_kk')->get();
        $banjars = Banjar::orderBy('nama')->get();

        return view('penduduk.edit', compact('penduduk','kks','banjars'));
    }


    public function update(Request $request, $id)
    {
        $penduduk = Penduduk::findOrFail($id);

        $data = $request->validate([
            'nama' => 'required|string|max:191',
             'nik' => [
                'nullable',
                'string',
                Rule::unique('penduduk', 'nik')->ignore($penduduk->id)],
            'jenis_kelamin' => ['required', Rule::in(['L','P','l','p','Laki-laki','Perempuan'])],
            'tanggal_lahir' => 'nullable|date',
            'tempat_lahir' => 'nullable|string|max:191',
            'alamat' => 'nullable|string',
            'kk_id' => 'nullable|exists:kks,id',
            'banjar_id' => 'nullable|exists:banjar,id',
            'kewarganegaraan' => 'nullable|string|max:50',

            // 'desa' => 'nullable|string|max:191',
            // 'kecamatan' => 'nullable|string|max:191',
            // 'kabupaten' => 'nullable|string|max:191',
            // 'provinsi' => 'nullable|string|max:191',
            // 'agama' => 'nullable|string|max:50',
        ]);

        if (isset($data['jenis_kelamin'])) {
            $jk = strtoupper(substr($data['jenis_kelamin'],0,1));
            $data['jenis_kelamin'] = ($jk === 'L') ? 'L' : 'P';
        }

        $penduduk->update($data);

        return redirect()->route('penduduk.index', $penduduk->id)->with('success', 'Data penduduk diupdate.');
    }

    public function destroy($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $penduduk->delete();
        return redirect()->route('penduduk.index')->with('success','Data penduduk dihapus.');
    }
}
