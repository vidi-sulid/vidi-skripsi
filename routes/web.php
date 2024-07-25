<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Master\CoaController;
use App\Http\Controllers\Master\MemberController;
use App\Http\Controllers\Master\ProductAsetController;
use App\Http\Controllers\Master\ProductLoanController;
use App\Http\Controllers\Master\ProductSavingController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\System\PermissionController;
use App\Http\Controllers\System\ProfileController;
use App\Http\Controllers\System\SettingController;
use App\Http\Controllers\System\UserController;
use App\Http\Controllers\System\UserDateController;
use App\Http\Controllers\Transaksi\AsetController;
use App\Http\Controllers\Transaksi\BookTransferController;
use App\Http\Controllers\Transaksi\CashierController;
use App\Http\Controllers\Transaksi\JournalController;
use App\Http\Controllers\Transaksi\LoanController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect()->route('dashboard');
});


Route::middleware('auth')->group(function () {

    Route::get("info", function () {
        phpinfo();
    });
    Route::get('/dashboard', [HomeController::class, 'show'])->name('dashboard');
    Route::get('backup', [HomeController::class, 'backup'])->name('backup.index');
    Route::get('versi', [HomeController::class, 'versi'])->name('versi.index');

    Route::resource('user', UserController::class);
    Route::resource('coa', CoaController::class);

    Route::resource('permission', PermissionController::class);
    Route::resource('journal', JournalController::class);
    Route::resource('product-aset', ProductAsetController::class);
    Route::resource('product-saving', ProductSavingController::class);
    Route::resource('product-loan', ProductLoanController::class);
    Route::resource('member', MemberController::class);
    Route::resource('aset', AsetController::class);
    Route::resource('loan', LoanController::class);
    Route::resource('user-date', UserDateController::class);
    Route::resource('cashier', CashierController::class);
    Route::resource('profile-user', ProfileController::class);
    Route::resource('setting', SettingController::class);
    Route::resource('booktransfer', BookTransferController::class);


    Route::get('journal-closing', [JournalController::class, 'close'])->name('journal-closing');
    Route::post('journal-closing', [JournalController::class, 'closed'])->name('journal-closing.store');

    Route::get('aset-report', [ReportController::class, 'asetReport'])
        ->name('aset-report.index');
    Route::get('journal-report', [ReportController::class, 'journalReport'])
        ->name('journal-report.index');

    Route::get('member-report', [ReportController::class, 'memberReport'])
        ->name('member-report.index');


    Route::get('loan-report', [ReportController::class, 'loanReport'])
        ->name('loan-report.index');


    Route::get('balancesheet-report', [ReportController::class, 'balancesheetReport'])
        ->name('balancesheet-report.index');


    Route::get('profitloss-report', [ReportController::class, 'profitlossReport'])
        ->name('profitloss-report.index');


    Route::get('bookledger-report', [ReportController::class, 'bookledgerReport'])
        ->name('bookledger-report.index');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/print.php';