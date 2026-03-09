<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CartController;
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

Route::resource('/menus',      MenuController::class);
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
    Route::resource('/orders', OrderController::class);
    Route::get('/report/export-pdf', [ReportController::class, 'exportPdf']); // harus sebelum resource
    Route::resource('/report', ReportController::class);
    Route::resource('/transaction', TransactionController::class);
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::get('/cart/{userId}', [CartController::class, 'viewCart']);
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::put('/cart/update/{itemId}', [CartController::class, 'updateCartItem']);
    Route::delete('/cart/remove/{itemId}', [CartController::class, 'removeCartItem']);
    Route::post('/cart/checkout/{userId}', [CartController::class, 'checkout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/categories', [CatController::class, 'index']);
    Route::get('/menus', [MenuController::class, 'index']);
     Route::get('/cart/{userId}', [CartController::class, 'viewCart']);
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::put('/cart/update/{itemId}', [CartController::class, 'updateCartItem']);
    Route::delete('/cart/remove/{itemId}', [CartController::class, 'removeCartItem']);
    Route::post('/cart/checkout/{userId}', [CartController::class, 'checkout']);
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::get('/transaction', [TransactionController::class, 'index']);
});