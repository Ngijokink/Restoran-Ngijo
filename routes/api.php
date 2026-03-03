<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CrudCatController;
use App\Http\Controllers\Api\CrudMenusController;

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
Route::middleware(['auth:sanctum', 'role:guru'])->group(function (){
    // Routes for Categories
    Route::get('/categories', [CrudCatController::class, 'index']);
    Route::get('/categories/{id}', [CrudCatController::class, 'show']);
    Route::post('/categories', [CrudCatController::class, 'store']);
    Route::put('/categories/{id}', [CrudCatController::class, 'update']);
    Route::delete('/categories/{id}', [CrudCatController::class, 'destroy']);
    Route::post('/logout',[AuthController::class,'logout']);
    
    // Routes for Menus
    Route::get('/menus', [CrudMenusController::class, 'index']);
    Route::get('/menus/{id}', [CrudMenusController::class, 'show']);
    Route::post('/menus', [CrudMenusController::class, 'store']);
    Route::put('/menus/{id}', [CrudMenusController::class, 'update']);
    Route::delete('/menus/{id}', [CrudMenusController::class, 'destroy']);  
    
});
