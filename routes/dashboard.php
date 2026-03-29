<?php

use App\Http\Controllers\Dashboard\Auth\AuthController;
use App\Http\Controllers\Dashboard\Auth\ForgetPasswordController;
use App\Http\Controllers\Dashboard\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use \App\Http\Controllers\Dashboard\welcomeController;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . "/dashboard",
        'as' => 'dashboard.',
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

        Route::get('/', function () {
            return redirect()->route('dashboard.login');
        })->name('index');

        ################### AUTH ROUTES ###################
        Route::get('login' , [AuthController::class , 'showLoginForm'])->name('login');
        Route::post('login' , [AuthController::class , 'login'])->name('login.post');
        Route::post('logout' , [AuthController::class , 'logout'])->name('logout');

        ################### FORGET PASSWORD ROUTES ###################
        Route::group(['prefix' => 'password' , 'as' => 'password.'] , function(){

            Route::controller(ForgetPasswordController::class)->group(function () {
                Route::get('email' , 'showForgetPasswordForm')->name('email');
                Route::post('email' , 'sendOtp')->name('email.post');
                Route::get('verify/{email}' , 'showOtpForm')->name('verify');
                Route::post('verify/' , 'verifyOtp')->name('verify.post');
            });
            Route::controller(ResetPasswordController::class)->group(function () {
                Route::get('reset/{email}' , 'showResetForm')->name('reset');
                Route::post('reset/' , 'resetPassword')->name('reset.post');
            });

        });

        ################### protected routes ###################
        Route::group(['middleware' => 'auth:admin'], function () {

            ################### welcome Routes ###################
            Route::get('welcome' , [welcomeController::class , 'index'])->name('welcome');

        });

});

Route::get('email' , function(){
    return view('dashboard.auth.password.email');
});




