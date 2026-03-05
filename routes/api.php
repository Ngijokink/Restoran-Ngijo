<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CatController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\PaymentController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!!
|
*/
// Authentication Routes
Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/register/asjdkbaskjdnaskdjbasdkasndaskjdbansdaskdjbasndmad/admin',[AuthController::class,'registerAdmin']);

Route::middleware(['auth:sanctum','role:admin'])->group(function (){
    // Routes for Categories
    Route::resource('/categories',CatController::class);
    Route::resource('/menus',MenuController::class);
    Route::resource('/orders',OrderController::class);
    // Report routes - custom route harus sebelum resource
    Route::get('/report/export-pdf',[ReportController::class, 'exportPdf']);
    Route::resource('/report',ReportController::class);
    Route::resource('/transaction',TransactionController::class);
    Route::put('/users/{id}/role', [AuthController::class, 'updateRole']);
    Route::get('/users', [AuthController::class, 'user']);
    Route::post('/logout',[AuthController::class,'logout']);
    Route::post('/payments', [PaymentController::class, 'store']);
    
});
