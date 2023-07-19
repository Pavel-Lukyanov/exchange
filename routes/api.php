<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SearchServicedObjectController;
use App\Http\Controllers\ServicedObjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('register', [AuthController::class, 'register']);

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'showUser']);

    Route::prefix('/objects')->group(function () {
        Route::get('/{id}', [ServicedObjectController::class, 'showObject']);
        Route::get('/', [ServicedObjectController::class, 'index']);

        Route::post('/create', [ServicedObjectController::class, 'create']);
    });
    Route::get('/search-objects', [SearchServicedObjectController::class, 'search']);


});

