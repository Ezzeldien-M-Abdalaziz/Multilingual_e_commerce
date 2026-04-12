<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Notifications\SendOtpNotify;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ForgetPasswordController extends Controller
{

    protected $otp2;

    public function __construct(){
        $this->otp2 = new Otp();
    }

    public function showEmailForm(){
        return view('dashboard.auth.password.email');
    }

    public function sendOtp(Request $request){
        $request->validate([
            'email' => 'required|email|exists:admins,email'
        ]);

        $admin = Admin::where('email' , $request->email)->first();
        if(!$admin){
            Session::flash('error' , __('dashboard.email_not_found'));
            return redirect()->back();
        }

        $admin->notify(new SendOtpNotify());
        return redirect()->route('dashboard.password.verify' , $request->email)->with('success' , __('dashboard.otp_sent'));
    }

    public function showOtpForm($email){
        return view('dashboard.auth.password.confirm' , compact('email'));
    }

    public function verifyOtp(Request $request){
//        return $request->all();
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'code' => 'required'
        ]);
        $otp = $this->otp2->validate($request->email , $request->code);
        if($otp->status == false){
            return redirect()->back()->with('error' , __('dashboard.invalid_otp'));
        }
        return redirect()->route('dashboard.password.reset' , $request->email)->with('success' , __('dashboard.otp_verified'));

    }



}














