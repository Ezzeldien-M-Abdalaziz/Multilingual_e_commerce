<?php

namespace App\Repositories\Auth;

use App\Models\Admin;
use Ichtrojan\Otp\Otp;

class PasswordRepository
{
    /**
     * Create a new class instance.
     */
    protected $otp2;
    public function __construct()
    {
        $this->otp2 = new Otp();
    }

    public function sendOtp($email){
        $admin = Admin::where('email' , $email)->first();
        return $admin;
    }

    public function verifyOtp($email , $code){
        $otp = $this->otp2->validate($email , $code);   //validate is check if the code is valid in the db
        return  $otp;
    }



}
