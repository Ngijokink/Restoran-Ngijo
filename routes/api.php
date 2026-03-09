<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\OrderItemController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CatController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\PaymentController;

Route::post('/login',    [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/setup/superadmin', [AuthController::class, 'registerSuperAdmin']);

Route::middleware(['auth:sanctum', 'role:superadmin'])->group(function () {
    Route::post('/register/admin', [AuthController::class, 'registerAdmin']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    Route::resource('/items', OrderItemController::class);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/users',              [AuthController::class, 'users']);
    Route::put('/users/{id}/role',    [AuthController::class, 'updateRole']);

    Route::resource('/categories', CatController::class);
    Route::resource('/menus',      MenuController::class);

    Route::resource('/orders', OrderController::class);

    Route::get('/report/export-pdf', [ReportController::class, 'exportPdf']); // harus sebelum resource
    Route::resource('/report', ReportController::class);

    Route::resource('/transaction', TransactionController::class);
    Route::post('/payments', [PaymentController::class, 'store']);
});