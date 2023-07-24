<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\PlatformUsersController;
use App\Http\Controllers\ScoresController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth'], function () {

        // Authentication route
        Route::post('/signup', [AuthController::class, 'signup']);
        Route::post('/signin', [AuthController::class, 'signin']);
        Route::post('/signout', [AuthController::class, 'signout'])->middleware('auth:sanctum');
    });

    Route::middleware('auth:sanctum')->group(function () {
        //me route
        Route::get('/me', [AuthController::class, 'me']);

        // scores route
        Route::get('/games/{slug}/scores', [ScoresController::class, 'getScores']);
        Route::post('/games/{slug}/scores', [ScoresController::class, 'storeScore']);
        // games route
        Route::get('games', [GamesController::class, 'paginatedGames']);
        Route::post('games', [GamesController::class, 'uploadGame']);

        Route::get('games/{slug}', [GamesController::class, 'gameDetail']);
        Route::post('games/{slug}/upload', [GamesController::class, 'uploadGameFile']);

        Route::get('/games/{slug}/{version}', [GamesController::class, 'serveGame']);
        Route::put('/games/{slug}', [GamesController::class, 'editGame']);
        Route::delete('/games/{slug}', [GamesController::class, 'deleteGame']);

        // users route
        Route::get('users/{username}', [PlatformUsersController::class, 'getUser']);
    });
});
