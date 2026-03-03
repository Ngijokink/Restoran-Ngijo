<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\CrudCatController;
use App\Http\Controllers\Api\Auth\MenusController;

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

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/logout',[AuthController::class,'logout']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
    Route::get('/categories', [CrudCatController::class, 'index']);
    Route::get('/categories/{id}', [CrudCatController::class, 'show']);
    Route::post('/categories', [CrudCatController::class, 'store']);
    Route::put('/categories/{id}', [CrudCatController::class, 'update']);
    Route::delete('/categories/{id}', [CrudCatController::class, 'destroy']);
    Route::get('/menus', [MenusController::class, 'index']);
    Route::get('/menus/{id}', [MenusController::class, 'show']);
    Route::post('/menus', [MenusController::class, 'store']);
    Route::put('/menus/{id}', [MenusController::class, 'update']);
    Route::delete('/menus/{id}', [MenusController::class, 'destroy']);  

});

