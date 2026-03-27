<?php

use App\Http\Controllers\Dashboard\Auth\AuthController;
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
        Route::middleware('guest:admin')->group(function () {
            Route::get('login' , [AuthController::class , 'showLoginForm'])->name('login');
            Route::post('login' , [AuthController::class , 'login'])->name('login.post');
        });

        Route::post('logout' , [AuthController::class , 'logout'])
            ->middleware('auth:admin')
            ->name('logout');

        ################### protected routes ###################
        Route::group(['middleware' => 'auth:admin'], function () {

            ################### welcome Routes ###################
            Route::get('welcome' , [welcomeController::class , 'index'])->name('welcome');

        });

});



