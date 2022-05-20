<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('home');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/manage-user', [App\Http\Controllers\ManageUserController::class, 'index'])->name('users');
    Route::get('/manage-user/add', [App\Http\Controllers\ManageUserController::class, 'add'])->name('add-users');
    Route::post('/manage-user/add/process', [App\Http\Controllers\ManageUserController::class, 'add_process'])->name('add-users-process');
    Route::get('/manage-user/edit/{id}', [App\Http\Controllers\ManageUserController::class, 'edit'])->name('edit-users');
    Route::post('/manage-user/edit/{id}/process', [App\Http\Controllers\ManageUserController::class, 'edit_process'])->name('edit-users-process');
    Route::post('/manage-user/delete', [App\Http\Controllers\ManageUserController::class, 'delete_process'])->name('delete-users-process');
    Route::post('/manage-user/activate', [App\Http\Controllers\ManageUserController::class, 'activate_process'])->name('activate-users-process');
    Route::post('/manage-user/deactivate', [App\Http\Controllers\ManageUserController::class, 'deactivate_process'])->name('deactivate-users-process');

    Route::get('/shopee-scrapper', [App\Http\Controllers\ShopeeScrapController::class, 'index'])->name('shopee');
    Route::get('/shopee-scrapper/add', [App\Http\Controllers\ShopeeScrapController::class, 'add'])->name('add_shopee');
});
