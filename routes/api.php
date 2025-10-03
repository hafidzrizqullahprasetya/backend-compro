<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VisionMissionController;
use App\Http\Controllers\AdminController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Vision and Mission Routes
Route::get('/vision-mission', [VisionMissionController::class, 'index']);
Route::get('/vision-mission/{id}', [VisionMissionController::class, 'show']);
Route::post('/vision-mission', [VisionMissionController::class, 'store']);
Route::put('/vision-mission/{id}', [VisionMissionController::class, 'update']);
Route::delete('/vision-mission/{id}', [VisionMissionController::class, 'destroy']);

//Admin Routes
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/{id}', [AdminController::class, 'show']);
Route::post('/admin', [AdminController::class, 'store']);
Route::put('/admin/{id}', [AdminController::class, 'update']);
Route::delete('/admin/{id}', [AdminController::class, 'destroy']);
