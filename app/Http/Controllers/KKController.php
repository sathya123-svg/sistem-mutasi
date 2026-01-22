<?php

namespace App\Http\Controllers;

use App\Models\KK;
use App\Models\Penduduk;
use App\Models\Banjar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Exports\KKExport;
use Maatwebsite\Excel\Facades\Excel;
class KKController extends Controller
{
    // List KK

        public function index(Request $request)
        {
            $user   = $request->user();
            $search = $request->search;

            if ($user->role === 'superadmin') {

                $KK = KK::when($search, function ($query) use ($search) {
                        $query->where(function ($q) use ($search) {

                            // nomor KK
                            $q->where('nomor_kk', 'like', "%{$search}%")

                            // nama SIAPAPUN dalam KK
                            ->orWhereHas('penduduk', function ($p) use ($search) {
                                $p->where('nama', 'like', "%{$search}%");
                            });

                        });
                    })
                    ->orderBy('nomor_kk')
                    ->paginate(25);

            } else {

                $kk = KK::where('banjar_id', $user->banjar_id)
                    ->when($search, function ($query) use ($search) {
                        $query->where(function ($q) use ($search) {

                            $q->where('nomor_kk', 'like', "%{$search}%")
                            ->orWhereHas('penduduk', function ($p) use ($search) {
                                $p->where('nama', 'like', "%{$search}%");
                            });

                        });
                    })
                    ->orderBy('nomor_kk')
                    ->paginate(25);
            }

            return view('kk.index', compact('kk'));
        }



        // public function index(Request $request)
        // {
        //     $user = $request->user();

        //     if ($user->role === 'superadmin') {
        //         $kk = KK::with('kepalaKeluargaPenduduk')->get();
        //     } else {
        //         $kk = KK::with('kepalaKeluargaPenduduk')
        //             ->where('banjar_id', $user->banjar_id)
        //             ->get();
        //     }

        //     return view('kk.index', compact('kk'));
        // }


            // Form Tambah KK
            public function create()
            {
                $user = Auth::user();

                if ($user->role === 'superadmin') {
                    // Super admin: semua penduduk yg belum punya KK
                    $penduduk = Penduduk::whereNull('kk_id')
                        ->orderBy('nama')
                        ->get();
                } else {
                    // Admin banjar: hanya penduduk banjar sendiri & belum punya KK
                    $penduduk = Penduduk::whereNull('kk_id')
                        ->where('banjar_id', $user->banjar_id)
                        ->orderBy('nama')
                        ->get();
                }

                return view('kk.create', compact('penduduk'));
            }

            // Simpan KK
            public function store(Request $request)
            {
                $request->validate([
                    'nomor_kk' => 'required|unique:kks,nomor_kk',
                    'kepala_keluarga' => 'required|exists:penduduk,id',
                ]);

                DB::transaction(function () use ($request) {

                    $kepala = Penduduk::find($request->kepala_keluarga);

                    // Buat KK
                    $kk = KK::create([
                        'nomor_kk' => $request->nomor_kk,
                        'kepala_keluarga' => $kepala->id,
                        'banjar_id' => $kepala->banjar_id,
                    ]);

                    // Update penduduk (kepala keluarga)
                    $kepala->kk_id = $kk->id;
                    $kepala->save();
                });

                return redirect()->route('kk.index')->with('success', 'KK berhasil dibuat.');
            }

            // Detail KK
            public function show($id)
            {
                $kk = KK::with(['kepalaKeluargaPenduduk', 'anggota'])->findOrFail($id);

                return view('kk.show', compact('kk'));
            }

            // Form tambah anggota
            public function addMember($id)
            {
                $kk = KK::findOrFail($id);
                $user = Auth::user();

                if ($user->role === 'superadmin') {
                    // Super admin: semua penduduk tanpa KK
                    $penduduk = Penduduk::whereNull('kk_id')
                        ->orderBy('nama')
                        ->get();
                } else {
                    // Admin banjar: hanya penduduk tanpa KK dari banjar KK tsb
                    $penduduk = Penduduk::whereNull('kk_id')
                        ->where('banjar_id', $kk->banjar_id)
                        ->orderBy('nama')
                        ->get();
                }

                return view('kk.add-member', compact('kk', 'penduduk'));
            }


            // Simpan anggota
            public function storeMember(Request $request, $id)
            {
                $request->validate([
                    'penduduk_id' => 'required|exists:penduduk,id',
                    'hubungan_keluarga' => 'required|string|max:100',
                    'anak_ke' => 'nullable|integer|min:1',
                ]);

                $penduduk = Penduduk::findOrFail($request->penduduk_id);
                $penduduk->kk_id = $id;
                $penduduk->hubungan_keluarga = $request->hubungan_keluarga;
                $penduduk->anak_ke = $request->anak_ke;
                $penduduk->save();

                return redirect()->route('kk.show', $id)
                    ->with('success', 'Anggota berhasil ditambahkan.');
            }

            //Export KK to Excel
            public function exportExcel(Request $request)
        {
            return Excel::download(
                new KKExport($request->user(), $request->search),
                fileName: 'data_kk.xlsx'
            );
        }

            // edit anggota
            public function editAnggota(KK $kk, Penduduk $penduduk)
        {
            // pastikan anggota ini milik KK tsb
            abort_if($penduduk->kk_id !== $kk->id, 403);

            return view('kk.edit-anggota', compact('kk', 'penduduk'));
        }

        public function gantiKepalaForm($id)
        {
            $kk = KK::with('anggota')->findOrFail($id);

            $calon = $kk->anggota
                ->where('id', '!=', $kk->kepala_keluarga_id);

            return view('kk.ganti-kepala', compact('kk', 'calon'));
        }

public function gantiKepala(Request $request, $id)
{
    $request->validate([
        'kepala_keluarga_id' => 'required|exists:penduduk,id'
    ]);

    $kk = KK::findOrFail($id);

    // simpan kepala keluarga lama
    $kepalaLamaId = $kk->kepala_keluarga;

    // 🔥 UPDATE KUNCI (INI YANG MENENTUKAN)
    $kk->update([
        'kepala_keluarga' => $request->kepala_keluarga_id
    ]);

    // kepala lama → anggota
    if ($kepalaLamaId) {
        Penduduk::where('id', $kepalaLamaId)
            ->update(['hubungan_keluarga' => 'Anggota']);
    }

    // kepala baru → kepala keluarga
    Penduduk::where('id', $request->kepala_keluarga_id)
        ->update(['hubungan_keluarga' => 'Kepala Keluarga']);

    return redirect()
        ->route('kk.show', $kk->id)
        ->with('success', 'Kepala keluarga berhasil diganti.');
}





        public function updateAnggota(Request $request, KK $kk, Penduduk $penduduk)
        {
            abort_if($penduduk->kk_id !== $kk->id, 403);

            $request->validate([
                'hubungan_keluarga' => 'required|string',
                'anak_ke' => 'nullable|integer|min:1',
            ]);

                $data = [
            'hubungan_keluarga' => $request->hubungan_keluarga,
            'anak_ke' => $request->hubungan_keluarga === 'Anak'
                ? $request->anak_ke
                : null,
                    ];

            $penduduk->update([
                'hubungan_keluarga' => $request->hubungan_keluarga,
                'anak_ke' => $request->hubungan_keluarga === 'Anak'
                    ? $request->anak_ke
                    : null, // 🔥 otomatis null kalau bukan Anak
            ]);


            return redirect()
                ->route('kk.show', $kk->id)
                ->with('success', 'Data anggota keluarga berhasil diperbarui.');
        }

}
