<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TwitterController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [RegisterController::class, 'register']);

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::resource('twitter', TwitterController::class);
    Route::get('user', [UserController::class, 'user']);
    Route::get('user/{username}', [UserController::class, 'profile']);
    Route::post('follow/{username}', [FollowerController::class, 'follow'])->name('follow');
    Route::post('un-follow/{username}', [FollowerController::class, 'un_follow'])->name('un_follow');
    Route::get('list-followed-tweet/{user}', [FollowerController::class, 'list_followed_tweet'])->name('list-followed-tweeted');
    Route::get('list-suggested-follow/{user}', [FollowerController::class, 'suggested_follow'])->name('list-suggested-follow');
});