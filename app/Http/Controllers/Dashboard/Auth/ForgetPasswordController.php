<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
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





}
