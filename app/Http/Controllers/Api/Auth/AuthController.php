<?php

namespace App\Http\Controllers\Api\Auth;

use App\Contracts\Services\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\Users\AuthUserRequest;
use App\Contracts\Services\AuthServiceInterface;

class AuthController extends Controller
{
    public function __construct(private AuthServiceInterface $authService, private UserServiceInterface $userService) {}

    public function register(RegisterUserRequest $request): JsonResponse
    {
        $response = $this->userService->create($request->validated());
        return $this->handleSuccessResponse($response['data'], $response['message'], 201);
    }

    public function login(AuthUserRequest $request): JsonResponse
    {
        $response = $this->authService->login($request->validated());
        return $this->handleWithCookieResponse($response['data'], $response['cookie'], $response['message']);
    }

    /**
     * Handles token renewal response
    */
    public function refresh(Request $request): JsonResponse
    {
        $response = $this->authService->refresh($request->cookie('refresh_token'));
        return $this->handleWithCookieResponse($response['data'], $response['cookie'], $response['message']);
    }

    /**
     * Handles app hydration response
     */
    public function hydrate(Request $request): JsonResponse
    {
        $response = $this->authService->hydrate($request->cookie('refresh_token'));
        return $this->handleSuccessResponse($response['data'], $response['message']);
    }

    /**
     * Handles logout response
     */
    public function logout(Request $request): JsonResponse
    {
        $response = $this->authService->logout($request->cookie('refresh_token'));
        return $this->handleSuccessResponse(null, $response);
    }
}
