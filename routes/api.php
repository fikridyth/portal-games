<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\GameController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('/categories', CategoryController::class);
Route::apiResource('/games', GameController::class)->except(['update']);
Route::put('games/{id}', [GameController::class, 'update']);