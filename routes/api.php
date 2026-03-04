<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CatController;
use App\Http\Controllers\Api\MenuController;

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
Route::middleware(['auth:sanctum'])->group(function (){
    // Routes for Categories
    Route::get('/categories', [CatController::class, 'index']);
    Route::get('/categories/{id}', [CatController::class, 'show']);
    Route::post('/categories', [CatController::class, 'store']);
    Route::put('/categories/{id}', [CatController::class, 'update']);
    Route::delete('/categories/{id}', [CatController::class, 'destroy']);
    Route::post('/logout',[AuthController::class,'logout']);
    
    // Routes for Menus
    Route::get('/menus', [MenuController::class, 'index']);
    Route::get('/menus/{id}', [MenuController::class, 'show']);
    Route::post('/menus', [MenuController::class, 'store']);
    Route::put('/menus/{id}', [MenuController::class, 'update']);
    Route::delete('/menus/{id}', [MenuController::class, 'destroy']);  
    
});
//code
