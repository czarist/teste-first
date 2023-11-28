<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

//user logged
Route::group(['middleware' => 'auth.user'], function () {
    Route::get('/', [App\Http\Controllers\UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');
    Route::get('/dados/{id}', [App\Http\Controllers\UserController::class, 'dados']);

    Route::put('/update_register', [App\Http\Controllers\ApiUserController::class, 'update_register'])->name('update_register');
    Route::delete('/delete_user', [App\Http\Controllers\ApiUserController::class, 'delete_user'])->name('delete_user');
});

//user login
Route::post('/user_login', [App\Http\Controllers\UserController::class, 'user_login']);
Route::get('/login', [App\Http\Controllers\UserController::class, 'login'])->name('login');

//user register
Route::get('/register', [App\Http\Controllers\UserController::class, 'register']);
