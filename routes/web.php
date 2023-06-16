<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [\App\Http\Controllers\TasksController::class, 'index'])->name('task.index');

Route::delete('/delete/{id}', [\App\Http\Controllers\TasksController::class, 'destroy'])->name('task.destroy');

Route::put('/update/{id}', [\App\Http\Controllers\TasksController::class, 'update'])->name('task.update');

Route::get('/show/{id}', [\App\Http\Controllers\TasksController::class, 'show'])->name('task.show');

Route::post('/store', [\App\Http\Controllers\TasksController::class, 'store'])->name('task.store');
