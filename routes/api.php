<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentVoteController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VotetopicController;
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

    Route::post('/user/update',  [UserController::class, 'update']);

    Route::get('/user/{id}/posts', [UserController::class, 'getTopicForUser']);
    Route::get('/user/{id}/comments', [UserController::class, 'getCommentsForUser']);


    // Routes for RoleController
    Route::get('roles', [RoleController::class, 'index']);


    // Routes for TopicController
    Route::post('/topics', [TopicController::class, 'storeTopic']);
    Route::get('/topics', [TopicController::class, 'index']);
    Route::get('/getTopicById/{id}', [TopicController::class, 'getTopicById']);
    Route::get('/commentsTopic/{id}', [TopicController::class, 'getTopicByIdForComments']);

    Route::delete('/topics/{id}', [TopicController::class, 'destroy']);
    Route::post('/topics/{id}', [TopicController::class, 'update']);

    // Routes for VotetopicController
    Route::post('/voteTopic', [VotetopicController::class, 'voteTopic']);

    // Routes for CommentController
    Route::post('/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
    Route::get('/comments/{id}', [CommentController::class, 'show']);
    Route::post('/commentUpdate/{id}', [CommentController::class, 'update']);
    Route::post('/validerComment' ,[CommentController::class, 'vliderComment']);
    

    // Routes for CommentVoteController
    Route::post('/commentTopic', [CommentVoteController::class, 'voteComment']);
});  