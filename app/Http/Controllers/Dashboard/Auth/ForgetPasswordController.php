<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgetPasswordController extends Controller
{
    public function showForgetPasswordForm(){
        return view('dashboard.auth.password.email');
    }

    public function sendResetLinkEmail(){
        return view('dashboard.auth.password.email');
    }


}
