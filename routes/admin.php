<?php

use App\Http\Controllers\Api\Admin\Auth\LoginController;
use App\Http\Controllers\Api\Admin\Auth\LogoutController;
use App\Http\Controllers\Api\Admin\BlogController;
use Illuminate\Support\Facades\Route;

Route::middleware([])->prefix('admin')->group(static function () {
    Route::post("login", [LoginController::class, 'login']);

    Route::group(['middleware' => ['auth:sanctum']], static function () {
        Route::group(['prefix' => 'profile'], static function () {
            Route::get("check-logged-in", [LoginController::class, 'check_logged_in']);
            Route::post("change-password", [LoginController::class, 'change_password']);
        });

        Route::post("logout", [LogoutController::class, 'logout']);
        Route::post("logout-all", [LogoutController::class, 'logout_all']);

        Route::group(['prefix' => 'blogs'], static function () {
            Route::get('load', [BlogController::class, 'index']);
            Route::get('show/{blog}', [BlogController::class, 'show']);
            Route::delete('delete/{blog}', [BlogController::class, 'destroy']);
            Route::put('change-active-status/{blog}', [BlogController::class, 'changeActiveStatus']);
        });
    });
});
