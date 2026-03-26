<?php

use App\Http\Controllers\Dashboard\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


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
});



