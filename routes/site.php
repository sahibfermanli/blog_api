<?php

use App\Http\Controllers\Api\Site\Auth\LoginController;
use App\Http\Controllers\Api\Site\Auth\LogoutController;
use App\Http\Controllers\Api\Site\Auth\RegisterController;
use App\Http\Controllers\Api\Site\BlogController;
use App\Http\Middleware\Api\BlogMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware([])->group(static function () {
    Route::post("register", [RegisterController::class, 'register']);

    Route::post("login", [LoginController::class, 'login']);

    Route::group(['middleware' => ['auth:sanctum']], static function () {
        Route::group(['prefix' => 'profile'], static function () {
            Route::get("check-logged-in", [LoginController::class, 'check_logged_in']);
            Route::post("change-password", [LoginController::class, 'change_password']);
        });

        Route::post("logout", [LogoutController::class, 'logout']);
        Route::post("logout-all", [LogoutController::class, 'logout_all']);

        Route::group(['prefix' => 'blogs', 'middleware' => [BlogMiddleware::class]], static function () {
            Route::get('load', [BlogController::class, 'index']);
            Route::get('show/{blog}', [BlogController::class, 'show']);
            Route::post('add', [BlogController::class, 'store']);
            Route::post('update/{blog}', [BlogController::class, 'update']);
            Route::delete('delete/{blog}', [BlogController::class, 'destroy']);
            Route::delete('/delete/image/{blog}/{media_id}', [BlogController::class, 'destroyImage'])->name('destroy_image');
        });
    });
});
