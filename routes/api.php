<?php

use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoundController;
use App\Http\Controllers\RoundVoteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('rounds', RoundController::class);
Route::put('rounds/{round}/finish', [RoundController::class, 'finish'])->name('rounds.finish');
Route::apiResource('rounds.votes', RoundVoteController::class);
Route::apiResource('rooms', RoomController::class)->only(['store', 'show']);
