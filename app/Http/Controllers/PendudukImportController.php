<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\KK;
use App\Models\Banjar;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PendudukImportController extends Controller
{
    public function showImportForm()
    {
        return view('penduduk.import');
    }




    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $rows = Excel::toArray(null, $request->file('file'))[0];

        DB::beginTransaction();

        try {
            foreach ($rows as $i => $row) {

                // skip header
                if ($i === 0) continue;

                // =========================
                // AMBIL DATA
                // =========================
                $nama         = trim($row[0] ?? '');
                $nik          = trim($row[1] ?? '');
                $jk_raw       = strtolower(trim($row[2] ?? ''));
                $tempat_lahir = trim($row[3] ?? '-');
                $alamat       = trim($row[5] ?? '-');
                // $nomor_kk     = trim($row[6] ?? '');
                $nama_banjar  = trim($row[6] ?? '');

                // =========================
                // VALIDASI PALING MINIMAL
                // =========================
                if ($nama === '' || $nama_banjar === '') {
                    continue;
                }

                // =========================
                // NORMALISASI JENIS KELAMIN
                // =========================
                if (in_array($jk_raw, ['l', 'laki-laki', 'laki laki'])) {
                    $jenis_kelamin = 'L';
                } elseif (in_array($jk_raw, ['p', 'perempuan'])) {
                    $jenis_kelamin = 'P';
                } else {
                    $jenis_kelamin = 'L'; // default aman
                }

                // =========================
                // TANGGAL LAHIR
                // =========================
                $tanggal_lahir = null;
                if (!empty($row[4])) {
                    if (is_numeric($row[4])) {
                        $tanggal_lahir = Date::excelToDateTimeObject($row[4])->format('Y-m-d');
                    } else {
                        $tanggal_lahir = date('Y-m-d', strtotime($row[4]));
                    }
                }

                // =========================
                // BANJAR (ANTI CASE-SENSITIVE)
                // =========================
                $banjar = Banjar::whereRaw(
                    'LOWER(TRIM(nama)) = ?',
                    [strtolower($nama_banjar)]
                )->first();

                if (!$banjar) {
                    continue;
                }

                // =========================
                // CEK DUPLIKAT NIK
                // =========================
                if ($nik !== '' && Penduduk::where('nik', $nik)->exists()) {
                    continue;
                }

                // =========================
                // KK (OPSIONAL)
                // =========================
                $kk_id = null;

                // if ($nomor_kk !== '') {
                //     $kk = KK::where('nomor_kk', $nomor_kk)->first();

                //     if (!$kk) {
                //         $kk = KK::create([
                //             // 'nomor_kk' => $nomor_kk,
                //             'banjar_id' => $banjar->id,
                //             'kepala_keluarga' => null,
                //         ]);
                //     }

                //     $kk_id = $kk->id;
                // }

                // =========================
                // SIMPAN PENDUDUK (PASTI MASUK)
                // =========================
                Penduduk::create([
                    'nama' => $nama,
                    'nik' => $nik ?: null,
                    'jenis_kelamin' => $jenis_kelamin,
                    'tempat_lahir' => $tempat_lahir,
                    'tanggal_lahir' => $tanggal_lahir,
                    'alamat' => $alamat,
                    'kewarganegaraan' => 'WNI',
                    'kk_id' => $kk_id,
                    'banjar_id' => $banjar->id,
                ]);
            }

            DB::commit();
            return back()->with('success', 'Import penduduk berhasil');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }
}



// namespace App\Http\Controllers;

// use App\Models\Penduduk;
// use App\Models\KK;
// use Illuminate\Http\Request;

// class PendudukImportController extends Controller
// {
//     public function showImportForm()
//     {
//         return view('penduduk.import');
//     }

//     public function import(Request $request)
//     {
//         $request->validate([
//             'file' => 'required|mimes:xlsx,xls'
//         ]);

//         $file = \Maatwebsite\Excel\Facades\Excel::toArray([], $request->file('file'));

//         $rows = $file[0];

//         foreach ($rows as $index => $row) {

//             if ($index == 0) continue; // skip heading

//             $nama = $row[0];
//             $nik = $row[1];
//             $alamat = $row[2];
//             $no_kk = $row[3];

//             $kk = KK::where('no_kk', $no_kk)->first();

//             if (!$kk) continue;

//             Penduduk::create([
//                 'nama' => $nama,
//                 'nik' => $nik,
//                 'alamat' => $alamat,
//                 'kk_id' => $kk->id,
//                 'banjar_id' => $kk->banjar_id
//             ]);
//         }

//         return back()->with('success', 'Import berhasil!');
//     }
// }
