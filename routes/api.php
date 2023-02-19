<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Counter\CounterController;
use App\Http\Controllers\Counter\QueueController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth:api'])->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);


    Route::get('/user-profile', [UserController::class, 'userProfile']);
    Route::get('/user-roles', [UserController::class, 'userRoles']);
    Route::get('/users', [UserController::class, 'getAllUsers']);
    Route::get('/user/getUserByCounter/{id}', [UserController::class, 'getAllUserByCounter']);


    Route::get('/counters', [CounterController::class, 'getAll']);
    Route::get('/counter/{id}', [CounterController::class, 'getOne']);
    Route::post('/counter', [CounterController::class, 'create']);
    Route::put('/counter/{counter}', [CounterController::class, 'update']);
    Route::delete('/counter/{id}', [CounterController::class, 'delete']);
    Route::post('/counter/assignUser/{id}', [CounterController::class, 'assigUser']);
    Route::delete('/counter/unAssignUser/{id}', [CounterController::class, 'unAssigUser']);
    Route::get('/counter/getByUser/{id}', [CounterController::class, 'getCounterByUser']);


    Route::get('/queues', [QueueController::class, 'getAll']);
    Route::get('/queue/{id}', [QueueController::class, 'getOne']);
    Route::post('/queue', [QueueController::class, 'create']);
    Route::put('/queue/{queue}', [QueueController::class, 'update']);
    Route::delete('/queue/{id}', [QueueController::class, 'delete']);
    Route::get('/queuesByCounter/{id}', [QueueController::class, 'getAllByCounter']);
    Route::put('/changeStatusQueue/{queue}', [QueueController::class, 'control']);
    Route::get('/queuesByCounter/today/{id}', [QueueController::class, 'getTodayData']);
    Route::get('/queueStatusOccure/{id}', [QueueController::class, 'getOccureStatus']);
    Route::get('/latestQueueByCounter/today/{id}', [QueueController::class, 'latestQueueByCounter']);
});

Route::post('/public/queue', [QueueController::class, 'createPublic']);
Route::get('/public/counters', [CounterController::class, 'getAllCounterPublic']);
Route::get('/public/latestQueueByCounter/today/{id}', [QueueController::class, 'latestQueueByCounterPublic']);