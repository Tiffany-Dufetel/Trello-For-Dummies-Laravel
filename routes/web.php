<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GuessController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');


Route::middleware('auth')->group(function () {
    Route::resource('/overviews', BoardController::class);

    Route::get('/tasks/{id}', [TaskController::class, 'index'])
        ->name('tasks.index');

    Route::post('/tasks/{id}', [TaskController::class, 'store'])
        ->name('tasks.store');

    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])
        ->name('tasks.destroy');

    Route::put('/tasks/{id}', [TaskController::class, 'update'])
        ->name('tasks.update');

    Route::post('/comments/{id}', [CommentController::class, 'store'])
        ->name('comments.store');

    Route::get('/profile-edit', [UserController::class, 'index'])
        ->name('profile-edit.index');

    Route::put('/profile-edit', [UserController::class, 'update'])
        ->name('profile-edit.update');

    Route::post('/guesses/{id}', [GuessController::class, 'store'])
        ->name('guesses.store');

    Route::delete('/guesses/{id}', [GuessController::class, 'destroy'])
        ->name('guesses.destroy');
});
