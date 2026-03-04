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
Route::post('/register/asjdkbaskjdnaskdjbasdkasndaskjdbansdaskdjbasndmad/admin',[AuthController::class,'registerAdmin']);
Route::resource('/categories',CatController::class);

Route::middleware(['auth:sanctum','role:admin'])->group(function (){
    // Routes for Categories
    Route::resource('/menus',MenuController::class);
    Route::put('/users/{id}/role', [AuthController::class, 'updateRole']);
    Route::get('/users', [AuthController::class, 'user']);
    Route::post('/logout',[AuthController::class,'logout']);
    
});
