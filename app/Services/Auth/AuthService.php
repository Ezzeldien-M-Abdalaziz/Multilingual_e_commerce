<?php
namespace App\Services\Auth;

use App\Repositories\Auth\AuthRepository;
class AuthService{

    protected AuthRepository $authRepository;
    public function __construct(AuthRepository $authRepository){
        $this->authRepository = $authRepository;
    }
    public function login($credentials, $guard, $remember): bool
    {
        return ($this->authRepository->login($credentials, $guard, $remember));
    }

    public function logout($guard): bool
    {
        return $this->authRepository->logout($guard);
    }
}
