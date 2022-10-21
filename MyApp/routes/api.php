<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//  return $request->user();
//});
Route::post('/register', [ApiController::class, 'register']);
Route::post('/login', [ApiController::class, 'login']);
Route::get('/detail', [ApiController::class, 'detail'])->middleware('auth:sanctum');
Route::post('/logout', [ApiController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/user', [ApiController::class, 'store'])->middleware('auth:sanctum');


Route::post('/forget', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'reset']);

Route::put('/update-profile', [ApiController::class, 'updateProfile'])->middleware('auth:sanctum');
Route::delete('/delete-profile', [ApiController::class, 'DeleteProfile'])->middleware('auth:sanctum');
