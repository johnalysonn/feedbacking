<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user/index', [UserController::class, 'index']);
    Route::get('/user/show', [UserController::class, 'show']);
});
Route::post('/user/login', [UserController::class, 'login']);
Route::post('/user/store', [UserController::class, 'store']);
Route::patch('/user/patch/{user}', [UserController::class, 'generateApiKey']);




