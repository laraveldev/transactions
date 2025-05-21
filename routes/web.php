<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ContentController;

use App\Http\Controllers\TransactionViewController;

Route::get('/', fn() => redirect('/transactions'));

Route::prefix('transactions')->group(function () {
    Route::get('/', [TransactionViewController::class, 'index'])->name('transactions.index');
    Route::get('/create', [TransactionViewController::class, 'create'])->name('transactions.create');
    Route::post('/', [TransactionViewController::class, 'store'])->name('transactions.store');
    Route::get('/{id}', [TransactionViewController::class, 'show'])->name('transactions.show');
});

Route::get('/salom',[ContentController::class,'index'])->name('salom');