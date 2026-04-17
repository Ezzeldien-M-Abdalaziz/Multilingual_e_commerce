<?php
namespace App\Repositories\Auth;

use Illuminate\Support\Facades\Auth;

class AuthRepository{

    //dynamic login using guard
    public function login($credentials, $guard, $remember = false): bool
    {
        return Auth::guard($guard)->attempt(
            $credentials, $remember
        );
    }

    public function logout($guard): bool
    {
        return Auth::guard($guard)->logout();
    }






}
