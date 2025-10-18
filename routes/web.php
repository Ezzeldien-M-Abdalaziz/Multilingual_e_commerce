<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


//this route group is for localization and every route in this group will be localized
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ //...
        Route::get('test' , function () {
            return view('dashboard.welcome');
        });
    });

    
Route::get('/', function () {
    return view('welcome');
});



