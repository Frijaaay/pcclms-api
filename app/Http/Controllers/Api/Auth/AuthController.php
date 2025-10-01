<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\AuthUserRequest;
use App\Contracts\Services\AuthServiceInterface;

class AuthController extends Controller
{
    /**
      * Constructor property promotion
      */
    public function __construct(private AuthServiceInterface $authService) {}

    /**
     * Handles login method
     */
    public function login(AuthUserRequest $request)
    {
        $response = $this->authService->login($request->validated());

        return response()->json([
            'message' => $response['message'],
            'token' => $response['token'],
            'user' => $response['user']
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
     * Handles app hydration method
     */
    public function hydrate()
    {
        $response = $this->authService->hydrate();

        return response()->json([
            'message' => $response['message'],
            'user' => $response['user']
        ]);
    }

    public function logout(Request $request)
    {
        $response = $this->authService->logout($request->cookie('refresh_token'));

        return response()->json([
            'message' => $response['message']
        ]);
    }

    public function refresh(Request $request)
    {
        $response = $this->authService->refresh($request->cookie('refresh_token'));

        return response()->json([
            'message' => 'Token refreshed',
            'token' => [
                'value' => $response['token'],
                'expires_in' => $response['expires_in']
            ]
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
}
