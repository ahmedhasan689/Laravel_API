<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:api'])->group(function() {
    Route::get('/posts', [PostController::class, 'index'])->name('Api.post.index');
    Route::get('/post/{id}', [PostController::class, 'show'])->name('Api.post.show');
    Route::post('/post', [PostController::class, 'store'])->name('Api.post.store');
    Route::put('/post/{id}', [PostController::class, 'update'])->name('Api.post.update');
    Route::delete('/post/{id}', [PostController::class, 'destroy'])->name('Api.post.delete');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});
