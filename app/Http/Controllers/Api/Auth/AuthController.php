<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\AuthUserRequest;
use App\Contracts\Services\AuthServiceInterface;

class AuthController extends Controller
{
    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

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
            path: '/',
            domain: null,
            secure: false,
            httpOnly: true,
            raw: false,
            sameSite: 'Strict'
            )
        );
    }

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
        ])->cookie(
            'refresh_token',
            $response['refresh_token'],
            $response['refresh_token_expiry']
        );
    }
}
