<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ItemsController;
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
        Route::patch('/mark/{invoiceId}', 'status');
        Route::post('/forms/draft', 'saveAsDraft');
        Route::get('/{invoiceId}', 'show');
        Route::patch('/{invoiceId}', 'update');
        Route::post('/{invoiceId}', 'destroy');
    });


    Route::get('/invoice/{invoiceId}/send-mail', [EmailController::class, 'sendEmail']);
});
