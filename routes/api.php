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

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::post('/login',    [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

/**
 * Setup awal: buat superadmin pertama.
 * Endpoint ini otomatis tidak bisa dipakai lagi setelah superadmin pertama
 * dibuat (handler melempar Exception jika superadmin sudah ada).
 *
 * Rekomendasi: hapus/nonaktifkan route ini setelah production setup selesai,
 * atau pindahkan ke artisan command / seeder.
 */
Route::post('/setup/superadmin', [AuthController::class, 'registerSuperAdmin']);

/*
|--------------------------------------------------------------------------
| Superadmin Routes — hanya superadmin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'role:superadmin'])->group(function () {
    // Buat akun admin baru
    Route::post('/register/admin', [AuthController::class, 'registerAdmin']);
});

/*
|--------------------------------------------------------------------------
| Admin & Superadmin Routes
| Middleware 'role:admin' sebaiknya menangani superadmin juga
| (superadmin >= admin), sesuaikan RoleMiddleware kamu.
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // User management
    Route::get('/users',              [AuthController::class, 'users']);
    Route::put('/users/{id}/role',    [AuthController::class, 'updateRole']);

    // Categories & Menus
    Route::resource('/categories', CatController::class);
    Route::resource('/menus',      MenuController::class);

    // Orders
    Route::resource('/orders', OrderController::class);

    // Reports
    Route::get('/report/export-pdf', [ReportController::class, 'exportPdf']); // harus sebelum resource
    Route::resource('/report', ReportController::class);

    // Transactions & Payments
    Route::resource('/transaction', TransactionController::class);
    Route::post('/payments', [PaymentController::class, 'store']);
});