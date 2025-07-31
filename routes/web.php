<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AsetMiddleware;
use App\Http\Middleware\KeuanganMiddleware;
use App\Http\Middleware\AdministrasiMiddleware;
use App\Http\Controllers\AdministrasiController;


Route::get('/', function () {
    return view('welcome');
})->name('Beranda');





Route::get('/administrasi/dashboard', [AdministrasiController::class, 'dashboard'])
    ->middleware(['auth', 'verified', AdministrasiMiddleware::class])
    ->name('administrasi.dashboard');

// Route untuk halaman index surat
Route::prefix('administrasi/dashboard')->name('administrasi.')->middleware(['auth', 'verified', AdministrasiMiddleware::class])->group(function() {
    // Gunakan resource dengan semua method termasuk index
    Route::resource('surat', AdministrasiController::class);
    
    // Tambahkan route untuk export PDF
Route::get('surat/{surat}/pdf', [AdministrasiController::class, 'exportPdf'])->name('surat.pdf');
});


Route::get('/aset/dashboard', function () {
    return view('aset.dashboard');
})->middleware(['auth', 'verified', AsetMiddleware::class])->name('aset.dashboard');


Route::get('/keuangan/dashboard', function () {
    return view('keuangan.dashboard');
})->middleware(['auth', 'verified', KeuanganMiddleware::class])->name('keuangan.dashboard');


















Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
