<?php

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

Route::group(['middleware' => 'auth:sanctum', 'role:storage'], function () {
    require_once 'storage.php';
});

Route::group(['middleware' => 'auth:sanctum', 'role:consultant'], function () {
    require_once 'consultant.php';
});

Route::post('login', [\App\Http\Controllers\API\Storage\AuthController::class, 'login']);
