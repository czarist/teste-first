<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiUserController;

Route::post('/save_register', [ApiUserController::class, 'save_register'])->name('save_user');
