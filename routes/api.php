<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\MarkAsPaidController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function(){
    Route::apiResource('invoice', InvoiceController::class);
    Route::apiResource('items', ItemsController::class);

    Route::prefix('invoice')->controller(InvoiceController::class)->group(function(){
        Route::patch('/mark/{id}', 'status');
        Route::post('/forms/draft', 'saveAsDraft');
    });
});
