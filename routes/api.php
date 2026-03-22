<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\userController;
use App\Http\Controllers\Api\productController;
 
// Usuarios
Route::get('/users',         [userController::class, 'index']);
Route::get('/users/{id}',    [userController::class, 'show']);
Route::post('/users',        [userController::class, 'store']);
Route::put('/users/{id}',    [userController::class, 'update']);
Route::delete('/users/{id}', [userController::class, 'destroy']);
 
// Productos
Route::get('/products',           [productController::class, 'index']);
Route::get('/products/{id}',      [productController::class, 'show']);
Route::post('/products',          [productController::class, 'store']);
Route::put('/products/{id}',      [productController::class, 'update']);
Route::delete('/products/{id}',   [productController::class, 'destroy']);