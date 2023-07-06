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

Route::get('/', function() {
    return redirect('/admin');
});


Route::get('/admin', [AdminUserController::class, 'index'])->name('admin');
Route::post('/login', [AdminUserController::class, 'login'])->name('admin.login.submit');
Route::post('/logout', [AdminUserController::class, 'logout'])->name('admin.logout');

Route::middleware(['auth:admin_users'])->group(function () {
    Route::get('/dashboard', [AdminUserController::class, 'index_dashboard'])->name('admin.dashboard');
    Route::get('/admin-users', [AdminUserController::class, 'admin_users']);
});

