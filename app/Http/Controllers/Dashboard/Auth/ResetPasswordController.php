<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\Admin;
use App\Services\Auth\PasswordService;

class ResetPasswordController extends Controller
{
    protected $passwordService;
    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    public function showResetForm($email){
        return view('dashboard.auth.password.reset' , compact('email'));
    }

    public function resetPassword(ResetPasswordRequest $request){

        $admin = $this->passwordService->resetPassword($request->email , $request->password);
        if (!$admin){
            return redirect()->back()->with('error' , __('dashboard.email_not_found'));
        }
        //redirect to login
        return redirect()->route('dashboard.login')->with('success' , __('dashboard.password_reset_success'));

    }
}
