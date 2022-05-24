<?php

use App\Models\User;
use Illuminate\Auth\TokenGuard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;

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

Route::post('scrapping', [App\Http\Controllers\APIController::class, 'scrapping']);

Route::get('login', [App\Http\Controllers\APIController::class, 'login']);
Route::get('cek-aktif', [App\Http\Controllers\APIController::class, 'cekAktif']);
Route::get('data/get', [\App\Http\Controllers\APIController::class, 'getData']);
