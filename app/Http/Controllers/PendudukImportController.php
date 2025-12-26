<?php
namespace App\Http\Controllers;

use App\Imports\PendudukImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PendudukImportController extends Controller
{
    public function showImportForm()
    {
        return view('penduduk.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new PendudukImport, $request->file('file'));

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil diimpor!');
    }
}
