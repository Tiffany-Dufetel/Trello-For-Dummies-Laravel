<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\TaskController;
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

Route::resource('/overviews', BoardController::class);

Route::get('/tasks/{id}', [TaskController::class, 'index'])
    ->name('tasks.index');

Route::post('/tasks/{id}', [TaskController::class, 'store'])
    ->name('tasks.store');

Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])
    ->name('tasks.destroy');

Route::put('/tasks/{id}', [TaskController::class, 'update'])
    ->name('tasks.update');

// Route::get('/tasks/{id}', [TaskController::class, 'edit'])
//     ->name('tasks.edit');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
