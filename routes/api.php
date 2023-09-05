<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, 'login']);
Route::put('/logout', [LoginController::class, 'logout']);

Route::prefix('tasks')->group(function () {
    Route::get('/', [TaskController::class, 'index']);  // Display details of all tasks 
    Route::post('/', [TaskController::class, 'store']); // Creates a new task
});

Route::prefix('tasks/{id}')->group(function () {
    Route::get('/', [TaskController::class, 'show']);         // Display details of a specific task
    Route::put('/', [TaskController::class, 'update']);       // Updates a specific task
    Route::delete('/', [TaskController::class, 'destroy']);   // Delete a specific task
    Route::put('/complete', [TaskController::class, 'complete']);    // Marks a specific task as concluded
})->middleware('auth');

Route::prefix('user')->group(function () {
    Route::post('/', [UserController::class, 'store']);     // Creates a new User
});

