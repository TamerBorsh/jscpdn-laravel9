<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProblemController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(AuthController::class)->group(function () {
    Route::post('login',                'login');
    Route::post('logout',               'logout');
});

Route::controller(ProblemController::class)->group(function () {
    Route::get('get_problems',           'get_problems');
    Route::post('add_problem',           'add_problem');

});