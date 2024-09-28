<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/user_registration',[UserController::class,'UserRegistration']);
Route::get('/user_login',[UserController::class,'UserLogin']);
