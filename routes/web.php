<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;
//API Routes
Route::post('/user-registration',[UserController::class,'UserRegister']);
Route::post('/user-login',[UserController::class,'UserLogin']);
Route::post('/send-otp',[UserController::class,'SendOTPCode']);
Route::post('/verify-otp',[UserController::class,'VerifyOTP']);
//Token Verify
Route::post('/reset-password',[UserController::class,'ResetPassword'])
    ->middleware(TokenVerificationMiddleware::class);


//Page RoutesResetPasswordPage

Route::get('/userLogin',[UserController::class,'LoginPage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage']);
Route::get('/resetPassword',[UserController::class,'']);
Route::get('/dashboard',[UserController::class,'DashboardPage']);
