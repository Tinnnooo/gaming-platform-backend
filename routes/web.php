<?php

use App\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/admin');
});


Route::get('/admin', [AdminUserController::class, 'index'])->name('admin');
Route::post('/login', [AdminUserController::class, 'login'])->name('admin.login.submit');
Route::post('/logout', [AdminUserController::class, 'logout'])->name('admin.logout')->middleware('auth:admin_users');

Route::middleware(['auth:admin_users'])->group(function () {
    Route::get('/dashboard', [AdminUserController::class, 'index_dashboard'])->name('admin.dashboard');
    Route::get('/manage-platform-users', [AdminUserController::class, 'index_platformUsers'])->name('admin.platformUsers');

    Route::get('/manage-platform-users/{username}', [AdminUserController::class, 'detail_platformUser']);

    Route::post('/manage-platform-users/{username}/block', [AdminUserController::class, 'block_platformUser']);

    Route::get('/manage-games', [AdminUserController::class, 'index_manageGames']);

    Route::get('/manage-games/game-scores', [AdminUserController::class, 'index_manageGameScores']);

    Route::post('/manage-games/{score_id}/delete', [AdminUserController::class, 'delete_gameScore']);
    Route::post('/manage-games/{game_id}/reset-scores', [AdminUserController::class, 'reset_gameScores']);
    Route::post('/manage-games/{version_id}/reset-highscores', [AdminUserController::class, 'reset_versionHighScores']);
});
