<?php

use App\Http\Controllers\Api\Site\Auth\LoginController;
use App\Http\Controllers\Api\Site\Auth\LogoutController;
use App\Http\Controllers\Api\Site\Auth\RegisterController;
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
    });
});
