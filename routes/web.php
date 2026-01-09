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
use App\Http\Controllers\KKController;
use App\Http\Controllers\KematianController;
use App\Http\Controllers\PendatangController;
use App\Http\Controllers\PerkawinanController;

// default redirect ke login
// Route::get('/', function () {
//     return redirect()->route('login');
// });

Route::get('/', function () {
    return redirect('/login');
});


// dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// semua route yang butuh authentikasi
Route::middleware('auth')->group(function () {

    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // import penduduk
    Route::get('/penduduk/import', [PendudukImportController::class, 'showImportForm'])->name('penduduk.import.form');
    Route::post('/penduduk/import', [PendudukImportController::class, 'import'])->name('penduduk.import');

    // CRUD utama
    Route::resource('penduduk', PendudukController::class);
    // Route::resource('mutasi', MutasiController::class);
    Route::get('/mutasi-masuk', [DashboardController::class, 'mutasiMasuk'])
    ->name('mutasi.masuk');

    Route::get('/mutasi-keluar', [DashboardController::class, 'mutasiKeluar'])
    ->name('mutasi.keluar');


    Route::get('/penduduk/{id}', [PendudukController::class, 'show'])->name('penduduk.show');
    

    Route::get('/penduduk', [PendudukController::class, 'index'])
    ->name('penduduk.index');


    Route::resource('kelahiran', \App\Http\Controllers\KelahiranController::class);
    Route::resource('kematian', \App\Http\Controllers\KematianController::class);
    Route::resource('pendatang', \App\Http\Controllers\PendatangController::class);
    Route::resource('perkawinan', \App\Http\Controllers\PerkawinanController::class);

    // KK
    Route::get('/kk', [KKController::class, 'index'])->name('kk.index');
    Route::get('/kk/create', [KKController::class, 'create'])->name('kk.create');
    Route::post('/kk/store', [KKController::class, 'store'])->name('kk.store');

    // Detail KK
    Route::get('/kk/{id}', [KKController::class, 'show'])->name('kk.show');

    // Tambah anggota
    Route::get('/kk/{id}/anggota/create', [KKController::class, 'addMember'])->name('kk.addMember');
    Route::post('/kk/{id}/anggota/store', [KKController::class, 'storeMember'])->name('kk.storeMember');

    // index
    Route::get('/kematian', [KematianController::class, 'index'])->name('kematian.index');
    Route::get('/pendatang', [PendatangController::class, 'index'])->name('pendatang.index');
    Route::get('/perkawinan', [PerkawinanController::class, 'index'])->name('perkawinan.index');

    // role
    Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('superadmin.dashboard');
    });


    Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');
    });



    // export
    Route::get('/penduduk/export/excel', function () {
        return Excel::download(new DataExport, 'data_penduduk.xlsx');
    })->name('penduduk.export.excel');

    Route::get('/kk/export/excel', [KKController::class, 'exportExcel'])
    ->name('kk.export.excel');

    Route::middleware(['auth'])->group(function () {
        Route::get('/kelahiran/export/excel', 
            [\App\Http\Controllers\KelahiranController::class, 'exportExcel']
        )->name('kelahiran.export.excel');

    });

    Route::get('/kematian/export/excel', [KematianController::class, 'exportExcel'])
    ->name('kematian.export.excel');
    Route::get('/perkawinan/export/excel', [PerkawinanController::class, 'exportExcel'])
    ->name('perkawinan.export.excel');

    Route::get('/pendatang/export/excel', [PendatangController::class, 'exportExcel'])
    ->name('pendatang.export.excel');

    


    // Route::get('/penduduk/export/pdf', function () {
    //     $penduduk = Penduduk::all();
    //     $pdf = Pdf::loadView('penduduk.pdf', compact('penduduk'));
    //     return $pdf->download('data_penduduk.pdf');
    // })->name('penduduk.export.pdf');

});

// ini wajib tetap di luar middleware auth
require __DIR__.'/auth.php';
