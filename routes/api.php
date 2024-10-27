<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;



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


Route::post('/login', [AuthController::class, 'login']);


Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/users', [AdminController::class, 'store']);
    Route::get('/users', [AdminController::class, 'getUsers']);
    Route::put('/users/{id}', [AdminController::class, 'update']);
    Route::delete('/users/{id}', [AdminController::class, 'destroy']);
    Route::get('/user-count', [AdminController::class, 'getUserCount']);


    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::put('/tasks/{id}', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
    Route::get('/task-count', [AdminController::class, 'getTaskCount']);
    Route::get('/completed-task-count', [AdminController::class, 'getCompletedTaskCount']);

});

Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    Route::get('/tasks', [TaskController::class, 'userTasks']);
    Route::get('/assigned-task-count', [UserController::class, 'getAssignedTaskCount']);
    Route::get('/completed-task-count', [UserController::class, 'getCompletedTaskCountByUser']);
});

Route::prefix('tasks')->middleware(['auth:sanctum'])->group(function () {
    Route::put('/{id}/status', [TaskController::class, 'updateStatus']);
});


