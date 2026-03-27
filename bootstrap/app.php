<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function  (){     //register dashboard.php routes
            Route::middleware('web')
            ->group(base_path('routes/dashboard.php'));
        }

    )
    ->withMiddleware(function (Middleware $middleware): void {
        //redirect guests
        $middleware->redirectGuestsTo(function (){
            if(request()->is('*/dashboard/*')){
                return route('dashboard.login');
            }

            return route('login');
        });

        $middleware->redirectUsersTo(function (){
            if(Auth::guard('admin')->check()){
                // If they're already trying to reach a dashboard route, let them continue
                if(request()->is('dashboard/*')) {
                    return null; // No redirect
                }
                return route('dashboard.welcome');
            }

            return route('/');
        });

        $middleware->alias([
            /**** OTHER MIDDLEWARE ALIASES ****/
            'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

