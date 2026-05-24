<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\AdminController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/about', function () {
    return Inertia::render('About', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('about');

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('/security', function () {
    return view('pages.security');
})->name('security');

Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('citizen.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'citizen'])->group(function () {
    Route::get('/citizen/dashboard', [CitizenController::class, 'dashboard'])->name('citizen.dashboard');
    Route::get('/citizen/land-records', [CitizenController::class, 'landRecords'])->name('citizen.land-records.index');
    Route::get('/citizen/land-records/{id}', [CitizenController::class, 'showLandRecord'])->name('citizen.land-records.show');
    
    // Land Transfer Routes
    Route::get('/citizen/land-records/{id}/transfer', [CitizenController::class, 'createTransferRequest'])->name('citizen.land-records.transfer');
    Route::post('/citizen/land-records/{id}/transfer', [CitizenController::class, 'storeTransferRequest'])->name('citizen.land-records.transfer.store');
    
    // Tax Payment Routes
    Route::get('/citizen/tax/{id}/pay', [CitizenController::class, 'showTaxPayment'])->name('citizen.tax.payment');
    Route::post('/citizen/tax/{id}/process', [CitizenController::class, 'processTaxPayment'])->name('citizen.tax.process');
    Route::get('/citizen/tax/receipt/{id}', [CitizenController::class, 'downloadReceipt'])->name('citizen.tax.receipt');
    
    // Payments History
    Route::get('/citizen/payments', [CitizenController::class, 'payments'])->name('citizen.payments');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Land Records CRUD
    Route::get('/land-records', [AdminController::class, 'indexLandRecords'])->name('land-records.index');
    Route::get('/land-records/export', [AdminController::class, 'exportLandRecords'])->name('land-records.export');
    Route::get('/land-records/create', [AdminController::class, 'createLandRecord'])->name('land-records.create');
    Route::post('/land-records', [AdminController::class, 'storeLandRecord'])->name('land-records.store');
    Route::get('/land-records/{id}/edit', [AdminController::class, 'editLandRecord'])->name('land-records.edit');
    Route::put('/land-records/{id}', [AdminController::class, 'updateLandRecord'])->name('land-records.update');
    Route::delete('/land-records/{id}', [AdminController::class, 'destroyLandRecord'])->name('land-records.destroy');
    
    // Tax Generation & Export
    Route::get('/taxes', [AdminController::class, 'indexTaxes'])->name('taxes.index');
    Route::get('/taxes/export', [AdminController::class, 'exportTaxes'])->name('taxes.export');
    Route::get('/taxes/generate', [AdminController::class, 'createTaxGeneration'])->name('taxes.generate');
    Route::post('/taxes/generate', [AdminController::class, 'storeTaxGeneration'])->name('taxes.store');
    
    // Transfer Requests
    Route::get('/transfers', [AdminController::class, 'indexTransfers'])->name('transfers.index');
    Route::post('/transfers/{id}/approve', [AdminController::class, 'approveTransfer'])->name('transfers.approve');
    Route::post('/transfers/{id}/reject', [AdminController::class, 'rejectTransfer'])->name('transfers.reject');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
