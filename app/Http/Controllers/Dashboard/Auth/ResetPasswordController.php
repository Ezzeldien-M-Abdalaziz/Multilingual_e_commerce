<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function showResetForm($email){
        return view('dashboard.auth.password.reset' , compact('email'));
    }

    public function resetPassword(Request $request){
        $request->validate([
            'email' => 'required|email|exists:admins,email',
            'password' => 'required', 'confirmed' ,
            'password_confirmation' => 'required|same:password'
        ]);
        $admin = Admin::where('email' , $request->email)->first();
        if (!$admin){
            return redirect()->back()->with('error' , __('dashboard.email_not_found'));
        }
        $admin->password = bcrypt($request->password);
        $admin->save();
        return redirect()->route('dashboard.login')->with('success' , __('dashboard.password_reset_success'));

    }
}
