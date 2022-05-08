<?php

use App\Http\Controllers\Web\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

 Route::get('/dashboard', function () {
     return view('dashboard');
 })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::namespace('web')
    ->middleware(['auth'])
    ->group(function() {

        // Start Post Route
        Route::group(
            [
                'prefix' => 'posts',
                'as' => 'post.',
            ], function() {
                Route::get('/', [PostController::class, 'index'])->name('index');
                Route::get('/create', [PostController::class, 'create'])->name('create');
                Route::post('/', [PostController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
                Route::put('/{id}', [PostController::class, 'update'])->name('update');
                Route::delete('/{id}', [PostController::class, 'destroy'])->name('delete');
        });
        // End Post Route

    });










