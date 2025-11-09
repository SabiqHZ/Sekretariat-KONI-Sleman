<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdministrasiController;
use App\Http\Controllers\GuestSuratController;
use App\Http\Controllers\JenisSuratController;
use App\Http\Middleware\AsetMiddleware;
use App\Http\Middleware\KeuanganMiddleware;
use App\Http\Middleware\AdministrasiMiddleware;
use App\Http\Middleware\SupervisorMiddleware;
use App\Exports\SuratExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('welcome');
})->name('Beranda');

Route::middleware(['auth', 'verified', AdministrasiMiddleware::class])
    ->prefix('administrasi/dashboard')
    ->name('administrasi.')
    ->group(function () {
        // Dashboard
        Route::get('/', [AdministrasiController::class, 'dashboard'])->name('dashboard');

        // Surat (resource: index, create, store, show, edit, update, destroy)
        Route::resource('surat', AdministrasiController::class);

        // Export PDF surat tertentu
        Route::get('surat/{surat}/pdf', [AdministrasiController::class, 'exportPdf'])
            ->name('surat.pdf');
        Route::patch('surat/{surat}/status', [AdministrasiController::class, 'updateStatus'])
            ->name('surat.update-status');


        // Jenis Surat (URL: jenissurat, nama route: jenis-surat.*)
        Route::resource('jenissurat', JenisSuratController::class)->names([
            'index'   => 'jenis-surat.index',
            'create'  => 'jenis-surat.create',
            'store'   => 'jenis-surat.store',
            'edit'    => 'jenis-surat.edit',
            'update'  => 'jenis-surat.update',
            'destroy' => 'jenis-surat.destroy',
        ]);
    });

/*
|--------------------------------------------------------------------------
| ASET
|--------------------------------------------------------------------------
*/
Route::get('/aset/dashboard', function () {
    return view('aset.dashboard');
})->middleware(['auth', 'verified', AsetMiddleware::class])
    ->name('aset.dashboard');

/*
|--------------------------------------------------------------------------
| KEUANGAN
|--------------------------------------------------------------------------
*/
Route::get('/keuangan/dashboard', function () {
    return view('keuangan.dashboard');
})->middleware(['auth', 'verified', KeuanganMiddleware::class])
    ->name('keuangan.dashboard');

Route::get('/supervisor/dashboard', function () {
    return view('supervisor.dashboard');
})->middleware(['auth', 'verified', SupervisorMiddleware::class])
    ->name('supervisor.dashboard');
Route::prefix('guest')->name('guest.')->group(function () {
    Route::get('/surat', [GuestSuratController::class, 'create'])->name('surat.create');
    Route::post('/surat', [GuestSuratController::class, 'store'])->name('surat.store');
});

Route::get('/surat/export', function () {
    return Excel::download(new SuratExport, 'data_surat.xlsx');
})->name('surat.export');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password');
});

require __DIR__ . '/auth.php';
