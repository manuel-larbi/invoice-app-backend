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

Route::apiResource('invoice', InvoiceController::class);

Route::patch('invoice/mark/{id}', [MarkAsPaidController::class, 'update']);

Route::apiResource('items', ItemsController::class);
