<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlatformController;

// User operations
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
	return $request->user();
});

// Games
Route::get('/games', [GameController::class, 'index']);
Route::get('/games/search/{query}', [GameController::class, 'search']);
Route::get('/games/{slug}', [GameController::class, 'show']);

// Platforms
Route::get('/platforms', [PlatformController::class, 'index']);
Route::get('/platforms/search/{query}', [PlatformController::class, 'search']);
Route::get('/platforms/{slug}', [PlatformController::class, 'show']);
