<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function showResetForm($email){
        return view('dashboard.auth.password.reset' , compact('email'));
    }

    public function resetPassword(){

    }
}
