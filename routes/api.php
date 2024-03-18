<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);

      // Routes for CategoryController
    Route::get('categories', [CategoryController::class, 'index']);
    Route::post('categories', [CategoryController::class, 'store']);
    Route::get('categories/{id}', [CategoryController::class, 'show']);
    Route::put('categories/{id}', [CategoryController::class, 'update']);
    Route::delete('categories/{id}', [CategoryController::class, 'destroy']);

     // Routes for TagController
     Route::get('tags', [TagController::class, 'index']);
     Route::post('tags', [TagController::class, 'store']);
     Route::get('tags/{id}', [TagController::class, 'show']);
     Route::put('tags/{id}', [TagController::class, 'update']);
     Route::delete('tags/{id}', [TagController::class, 'destroy']);

    // Routes for UserController
    Route::get('users', [UserController::class, 'index']);
    Route::post('users/{id}/block', [UserController::class, 'blockUser']);
    Route::put('users/{id}/role', [UserController::class, 'updateUserRole']);

    // Routes for RoleController
    Route::get('roles', [RoleController::class, 'index']);
});  