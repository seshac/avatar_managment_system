<?php

use App\Http\Controllers\ItemController;
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

Route::get('/items', [ItemController::class, 'index']);
Route::get('/user/{user}/items', [ItemController::class, 'currentAvatarItems']);
Route::put('/user/{user}/item/{item}/buy', [ItemController::class, 'buy']);
Route::post('/user/{user}/items/activate', [ItemController::class, 'activateItems']);
