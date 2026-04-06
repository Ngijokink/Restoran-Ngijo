<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CatController;
use App\Http\Controllers\Api\MejaController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\PaymentController;

// ==========================================
// 🔓 PUBLIC (No Auth)
// ==========================================
Route::post('/login',             [AuthController::class, 'login']);
Route::post('/register',          [AuthController::class, 'register']);

// Meja - GET public (semua bisa lihat tanpa login)
Route::get('/meja',       [MejaController::class, 'index']);
Route::get('/meja/{id}',  [MejaController::class, 'show']);

// Menu - Search public (harus sebelum show)
Route::get('/menus/search', [MenuController::class, 'search']);
Route::get('/categories/search', [CatController::class, 'search']);
Route::get('/categories/sort', [CatController::class, 'sorting']);
Route::get('/menus',        [MenuController::class, 'index']);
Route::get('/menus/{id}',   [MenuController::class, 'show']);
Route::get('/categories',   [CatController::class, 'index']);

// ==========================================
// 👑 SUPERADMIN
// ==========================================
Route::middleware(['auth:sanctum', 'role:superadmin'])->group(function () {
    // Categories
    Route::post('/logout',          [AuthController::class, 'logout']);
    Route::post('/register/admin',  [AuthController::class, 'registerAdmin']);
});

// ==========================================
// 🛡️ ADMIN
// ==========================================
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/logout',            [AuthController::class, 'logout']);
    Route::get('/users',              [AuthController::class, 'users']);
    Route::put('/users/{id}/role',    [AuthController::class, 'updateRole']);

    // Meja (full CRUD untuk admin)
    Route::post('/meja',          [MejaController::class, 'store']);
    Route::put('/meja/{id}',      [MejaController::class, 'update']);
    Route::delete('/meja/{id}',   [MejaController::class, 'destroy']);
});

// ==========================================
// 📊 MANAGER
// ==========================================
Route::middleware(['auth:sanctum', 'role:manager'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/categories',   [CatController::class, 'store']);

    // Menu (full CRUD)
    Route::get('/menus',          [MenuController::class, 'index']);
    Route::get('/menus/{id}',     [MenuController::class, 'show']);
    Route::post('/menus',         [MenuController::class, 'store']);
    Route::put('/menus/{id}',     [MenuController::class, 'update']);
    Route::delete('/menus/{id}',  [MenuController::class, 'destroy']);
    
    // Meja (hanya CUD, GET sudah public di atas)
    Route::post('/meja',          [MejaController::class, 'store']);
    Route::put('/meja/{id}',      [MejaController::class, 'update']);
    Route::delete('/meja/{id}',   [MejaController::class, 'destroy']);
    
    // Report (full CRUD + export PDF)
    Route::get('/report/export-pdf/{date}', [ReportController::class, 'exportPdf']); // harus sebelum resource
    Route::get('/report',          [ReportController::class, 'index']);
    Route::get('/report/{id}',     [ReportController::class, 'show']);
    Route::post('/report',         [ReportController::class, 'store']);
    Route::put('/report/{id}',     [ReportController::class, 'update']);
    Route::delete('/report/{id}',  [ReportController::class, 'destroy']);
});

// ==========================================
// 🛒 PELANGGAN
// ==========================================
Route::middleware(['auth:sanctum', 'role:pelanggan'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Cart
    Route::get('/cart/{userId}',           [CartController::class, 'viewCart']);
    Route::post('/cart/add',               [CartController::class, 'addToCart']);
    Route::put('/cart/update/{itemId}',    [CartController::class, 'updateCartItem']);
    Route::delete('/cart/remove/{itemId}', [CartController::class, 'removeCartItem']);
    Route::post('/cart/checkout/{userId}', [CartController::class, 'checkout']);
    
    // Payment
    Route::post('/payments', [PaymentController::class, 'store']);
    
    // Orders (full CRUD)
    Route::get('/orders',         [OrderController::class, 'index']);
    Route::get('/orders/{id}',    [OrderController::class, 'show']);
    Route::post('/orders',        [OrderController::class, 'store']);
    Route::put('/orders/{id}',    [OrderController::class, 'update']);
    Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
    
    Route::get('/menus',          [MenuController::class, 'index']);
    Route::get('/categories',    [CatController::class, 'index']);
});