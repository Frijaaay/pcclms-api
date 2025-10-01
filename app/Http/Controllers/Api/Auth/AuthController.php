<?php

namespace App\Http\Controllers\Api\Auth;

use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\AuthUserRequest;
use App\Contracts\Services\AuthServiceInterface;

class AuthController
{
    use ApiResponseTrait;

    public function __construct(private AuthServiceInterface $authService) {}

    /**
     * Handles login response
     */
    public function login(AuthUserRequest $request): JsonResponse
    {
        $response = $this->authService->login($request->validated());

        return response()->json([
            'message' => $response['message'],
            'content' => $response['data']
        ])->withCookie(
            cookie(
            name: 'refresh_token',
            value: $response['refresh_token'],
            minutes: $response['refresh_token_expiry'],
            path: '/api/v1/auth',
            domain: null,
            secure: env('SESSION_SECURE_COOKIE', app()->environment('production')),
            httpOnly: true,
            raw: false,
            sameSite: 'strict'
            )
        );
    }

    /**
     * Handles token renewal response
    */
    public function refresh(Request $request): JsonResponse
    {
        $response = $this->authService->refresh($request->cookie('refresh_token'));

        return response()->json([
            'message' => 'Token refreshed',
            'content' => $response['data']
        ])->withCookie(
            cookie(
            name: 'refresh_token',
            value: $response['refresh_token'],
            minutes: $response['refresh_token_expiry'],
            path: '/api/v1/auth',
            domain: null,
            secure: false,
            httpOnly: true,
            raw: false,
            sameSite: 'strict'
            )
        );
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
