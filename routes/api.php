<?php

use App\Http\Controllers\AuthController;
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
    Route::get('/user-profile', [AuthController::class, 'userProfile']);

    Route::get('/counters', [CounterController::class, 'getAll']);
    Route::get('/counter/{id}', [CounterController::class, 'getOne']);
    Route::post('/counter', [CounterController::class, 'create']);
    Route::put('/counter/{counter}', [CounterController::class, 'update']);
    Route::delete('/counter/{id}', [CounterController::class, 'delete']);
    Route::post('/counter/assignUser/{id}', [CounterController::class, 'assigUser']);
    Route::delete('/counter/unAssignUser/{id}', [CounterController::class, 'unAssigUser']);

    Route::get('/queues', [QueueController::class, 'getAll']);
    Route::get('/queue/{id}', [QueueController::class, 'getOne']);
    Route::post('/queue', [QueueController::class, 'create']);
    Route::put('/queue/{queue}', [QueueController::class, 'update']);
    Route::delete('/queue/{id}', [QueueController::class, 'delete']);
    Route::get('/queuesByCounter/{id}', [QueueController::class, 'getAllByCounter']);
    Route::put('/changeStatusQueue/{queue}', [QueueController::class, 'control']);
    Route::get('/queuesByCounter/today/{id}', [QueueController::class, 'getTodayData']);
    Route::get('/queueStatusWiting/{id}', [QueueController::class, 'getWittingStatus']);
    Route::get('/queueStatusOccure/{id}', [QueueController::class, 'getOccureStatus']);
});

Route::middleware('auth:api')->get('/user-profile', function (Request $request) {
    return $request->user();
});
