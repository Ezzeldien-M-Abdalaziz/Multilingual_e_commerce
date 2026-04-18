<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgetPasswordRequest;
use App\Models\Admin;
use App\Notifications\SendOtpNotify;
use App\Services\Auth\PasswordService;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ForgetPasswordController extends Controller
{

    protected $otp2;
    protected $passwordService;

    public function __construct(PasswordService $passwordService){
        $this->passwordService = $passwordService;
        $this->otp2 = new Otp();
    }

    public function showEmailForm(){
        return view('dashboard.auth.password.email');
    }

    public function sendOtp(ForgetPasswordRequest $request){

        $admin = $this->passwordService->getAdminByEmail($request->email);
        if(!$admin){
            return redirect()->back()->withErrors(['email' => __('dashboard.email_not_found')]);
        }
        return redirect()->route('dashboard.password.verify', $request->email)->withErrors(['success' => __('dashboard.otp_sent')]);
    }

    public function showOtpForm($email){
        return view('dashboard.auth.password.confirm' , compact('email'));
    }

    public function verifyOtp(ForgetPasswordRequest $request){

        $otpStatus = $this->passwordService->verifyOtp($request->email , $request->code);
        if(!$otpStatus){
            return redirect()->back()->withErrors(['error' => __('dashboard.invalid_otp')]);
        }
        return redirect()->route('dashboard.password.reset', $request->email)->withErrors(['success' => __('dashboard.otp_verified')]);

    }



}














