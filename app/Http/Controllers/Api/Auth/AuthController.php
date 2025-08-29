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
        $data = $this->authService->login($request->validated());

        return response()->json([
            'message' => $data['message'],
            'token' => $data['token'],
            'user' => $data['user']
        ])->withCookie(
            cookie(
            name: 'refresh_token',
            value: $data['refresh_token'],
            minutes: $data['refresh_token_expiry'],
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
