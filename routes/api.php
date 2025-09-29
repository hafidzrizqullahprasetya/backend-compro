<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisionMissionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/vision-mission', [VisionMissionController::class, 'index']);
Route::get('/vision-mission/{id}', [VisionMissionController::class, 'show']);
Route::post('/vision-mission', [VisionMissionController::class, 'store']);
Route::put('/vision-mission/{id}', [VisionMissionController::class, 'update']);
Route::delete('/vision-mission/{id}', [VisionMissionController::class, 'destroy']);

