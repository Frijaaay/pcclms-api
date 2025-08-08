<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\AuthUserRequest;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Contracts\Services\AuthServiceInterface;
use Psy\CodeCleaner\FunctionContextPass;

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

        $responseCode = $response['success'] ? 200 : 401;

        return response()->json([
            'message' => $response['message'] ?? 'Login attempt',
            'token' => $response['token'] ?? null,
            'data' => $response['authenticatedUser'] ?? null,
        ], $responseCode);
    }


    public function auth(Request $request)
    {
        $user = $request->validate([
            'id_number' => 'required|string|max:11',
            'password' => 'required|string',
        ]);

        $token = JWTAuth::attempt($user);

        try {
            if (!$token) {
                return response()->json([
                    'error' => 'Invalid Credentials'
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not create token'
            ], 500);
        }

        $user = JWTAuth::user();

        return response()->json([
            'token' => $token,
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => $user
        ]);
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }

        return response()->json(['message' => 'Successfully logged out']);
    }
}
