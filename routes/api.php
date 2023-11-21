<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OpenAIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('auth')->group(function () {
    Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/assistant', [OpenAIController::class, 'assistant']);
    Route::post('/translate', [OpenAIController::class, 'translate']);
    Route::post('/grammar', [OpenAIController::class, 'grammar']);
});
