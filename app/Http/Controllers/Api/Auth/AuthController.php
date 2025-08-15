<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Users\AuthUserRequest;
use App\Http\Controllers\Controller;
use App\Contracts\Services\AuthServiceInterface;

class AuthController extends Controller
{
    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function login(AuthUserRequest $request)//: JsonResponse
    {
        return $this->authService->login($request->validated());
    }

    public function hydrate()
    {
        return $this->authService->hydrate();
    }

    public function logout()//: JsonResponse
    {
        return $this->authService->logout();
    }
}
