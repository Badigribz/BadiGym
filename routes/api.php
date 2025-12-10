<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\WorkoutController;
use App\Http\Controllers\API\SplitController;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('workouts', WorkoutController::class);

    Route::get('splits', [SplitController::class, 'index']);
    Route::post('splits', [SplitController::class, 'store']);
    Route::post('splits/assign', [SplitController::class, 'assignWorkout']);
    Route::delete('splits/remove/{id}', [SplitController::class, 'removeWorkout']);
});

