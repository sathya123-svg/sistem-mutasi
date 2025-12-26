<?php

use App\Exports\DataExport;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MutasiController;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Penduduk;
use App\Http\Controllers\PendudukImportController;


Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/penduduk/import', [PendudukImportController::class, 'showImportForm'])->name('penduduk.import.form');
    Route::post('/penduduk/import', [PendudukImportController::class, 'import'])->name('penduduk.import');

    Route::resource('penduduk', PendudukController::class);
    Route::resource('mutasi', MutasiController::class);
    
    Route::get('/penduduk/{id}', [PendudukController::class, 'show'])->name('penduduk.show');
 
    
    Route::get('/penduduk/export/excel', function () {
    return Excel::download(new DataExport, 'data_penduduk.xlsx');
})->name('penduduk.export.excel')->middleware('auth');

    Route::get('/penduduk/export/pdf', function () {
    $penduduk = Penduduk::all();
    $pdf = Pdf::loadView('penduduk.pdf', compact('penduduk'));
    return $pdf->download('data_penduduk.pdf');
})->name('penduduk.export.pdf');

});

require __DIR__.'/auth.php';

//return view('welcome');