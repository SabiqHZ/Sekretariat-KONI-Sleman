<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AsetMiddleware;
use App\Http\Middleware\KeuanganMiddleware;
use App\Http\Middleware\AdministrasiMiddleware;
use App\Http\Middleware\SupervisorMiddleware;
use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\GuestSuratController;
use App\Http\Controllers\JenisSuratController;
use App\Exports\SuratExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Style\Supervisor;

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

Route::middleware(['auth', 'verified', AdministrasiMiddleware::class])
    ->prefix('administrasi/dashboard')
    ->name('administrasi.')
    ->group(function () {
        // Route untuk Jenis Surat (tetap gunakan 'jenissurat' sebagai URL)
        Route::resource('jenissurat', JenisSuratController::class)->names([
            'index' => 'jenis-surat.index',
            'create' => 'jenis-surat.create',
            'store' => 'jenis-surat.store',
            'edit' => 'jenis-surat.edit',
            'update' => 'jenis-surat.update',
            'destroy' => 'jenis-surat.destroy'
        ]);
    });


Route::get('/aset/dashboard', function () {
    return view('aset.dashboard');
})->middleware(['auth', 'verified', AsetMiddleware::class])->name('aset.dashboard');


Route::get('/keuangan/dashboard', function () {
    return view('keuangan.dashboard');
})->middleware(['auth', 'verified', KeuanganMiddleware::class])->name('keuangan.dashboard');




Route::get('/supervisor/dashboard', function () {
    return view('supervisor.dashboard');
})->middleware(['auth', 'verified', SupervisorMiddleware::class])->name('supervisor.dashboard');









// Guest Routes
Route::prefix('guest')->name('guest.')->group(function () {
    Route::get('/surat', [GuestSuratController::class, 'create'])->name('surat.create');
    Route::post('/surat', [GuestSuratController::class, 'store'])->name('surat.store');
});


Route::get('/surat/export', function() {
    return Excel::download(new SuratExport, 'data_surat.xlsx');
})->name('surat.export');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])
    ->name('profile.password');
    
});

require __DIR__.'/auth.php';
