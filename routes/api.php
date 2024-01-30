<?php

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

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Api\GeneralAccessMiddleware;

Route::middleware([GeneralAccessMiddleware::class])->group(static function () {
    require_once 'site.php';
    require_once 'admin.php';
});
