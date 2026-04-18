<?php

namespace App\Services\Auth;

use App\Notifications\SendOtpNotify;
use App\Repositories\Auth\PasswordRepository;

class PasswordService
{
    /**
     * Create a new class instance.
     */
    protected PasswordRepository $passwordRepository;
    public function __construct(PasswordRepository $passwordRepository)
    {
        $this->passwordRepository = new PasswordRepository();
    }

    public function sendOtp($email){
        $admin = $this->passwordRepository->sendOtp($email);
        if(!$admin){
            return false;
        }
        $admin->notify(new SendOtpNotify());
        return $admin;
    }

    public function verifyOtp($email , $code){
        $otp = $this->passwordRepository->verifyOtp($email , $code);
        return $otp->status;
    }
}
