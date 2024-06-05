<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Master\CoaController;
use App\Http\Controllers\Master\ProductAsetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\System\PermissionController;
use App\Http\Controllers\System\UserController;
use App\Http\Controllers\Transaksi\AsetController;
use App\Http\Controllers\Transaksi\JournalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [HomeController::class, 'show'])->name('dashboard');

    Route::resource('user', UserController::class);
    Route::resource('coa', CoaController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('journal', JournalController::class);
    Route::resource('product-aset', ProductAsetController::class);
    Route::resource('aset', AsetController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
