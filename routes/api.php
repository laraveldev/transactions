<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TransactionController;

Route::prefix('transactions')->group(function () {
    Route::get('/', [TransactionController::class, 'index']);
    Route::get('/create', [TransactionController::class, 'create']); // optional
    Route::post('/', [TransactionController::class, 'store']);
});





Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




