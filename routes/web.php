<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SportEventController;
use App\Http\Controllers\UserController;
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
    return view('login.index');
});

Route::resource('login', AuthController::class);
Route::resource('users', UserController::class)->except(['edit','update','destroy']);

Route::prefix('admin')->middleware('auth.api_token')->group(function () {
    Route::resource('users/profile', UserController::class)->only(['edit','update','destroy']);
    Route::get('user/logout', [UserController::class,'logout'])->name('users.logout');
    Route::put('user/{id}/password', [UserController::class,'updatePassword'])->name('users.password');
    Route::resource('dashboard', DashboardController::class);
    Route::resource('event', SportEventController::class);
});
