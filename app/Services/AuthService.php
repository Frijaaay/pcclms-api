<?php

namespace App\Services;

use App\Exceptions\AuthException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Contracts\Services\AuthServiceInterface;
use App\Contracts\Repositories\AuthRepositoryInterface;

class AuthService implements AuthServiceInterface
{
    private AuthRepositoryInterface $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(array $credentials)
    {
        $token = Auth::attempt($credentials);

        $user = Auth::user();

        if (is_null($user->email_verified_at)) {
            Auth::logout();
            return response()->json([
                'message' => 'Please verify your email before logging in.'
            ], 403);
        }
        if(!$token) {
            throw new AuthException();
        }

        return response()->json([
            'message' => 'Login successful',
            'token' => [
                'value' => $token,
                'expires_in' => Auth::factory()->getTTL() * 60,
            ],
            'user' => $user
        ], 200);
    }
    public function hydrate()
    {
            $user = Auth::user();

            if(!$user) {
                throw new AuthException();
            }

            /**@var \App\Models\User $user */
            $user->load('userType');

            return response()->json(['message' => 'Hydrated','user' => $user]);
    }
    public function logout()
    {
        try {
            JWTAuth::invalidate(Auth::getToken());
            return response()->json(['message' => 'Successfully logged out']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }

    }
}
