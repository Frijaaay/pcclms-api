<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Exceptions\AuthException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\EmailUnverifiedException;
use App\Contracts\Services\AuthServiceInterface;
use App\Contracts\Repositories\AuthRepositoryInterface;

class AuthService implements AuthServiceInterface
{
    /** Dependency Injection */
    public function __construct(private AuthRepositoryInterface $authRepository) {}

    /** Login method */
    public function login(array $credentials)
    {
        $access_token = auth()->attempt($credentials);

        if(!$access_token) {
            throw new AuthException();
        }

        $authUser = auth()->user();

        if (is_null($authUser->email_verified_at)) {
            throw new EmailUnverifiedException();
        }

        $refresh_token = $this->generateRefreshToken($authUser->id);

        return [
            'message' => 'Login is successful',
            'token' => [
                'type' => 'Bearer',
                'value' => $access_token,
                'expires_in' => JWTAuth::factory()->getTTL()
            ],
            'user' => $authUser,
            'refresh_token' => $refresh_token,
            'refresh_token_expiry' => 60 * 24 * 7
        ];
    }

    /** Create refresh token */
    private function generateRefreshToken(string $user_id)
    {
        $refresh_token = Str::random(64);

        if (!$this->authRepository->createRefreshToken($user_id, $refresh_token)) {
            throw new AuthException('Internal Server Error', 500);
        }

        return $refresh_token;
    }

    /** Hydrate user data */
    public function hydrate()
    {
            $user = auth()->user();

            if(!$user) {
                throw new AuthException();
            }

            $user->load('userType');

            return [
                'message' => 'Hydrated',
                'user' => $user
            ];
    }

    /** Logout method */
    public function logout(?string $refresh_token)
    {
            JWTAuth::invalidate(Auth::getToken());
            auth()->logout();

            $this->authRepository->revokeToken($refresh_token);

            return ['message' => 'Successfully logged out'];
    }

    /** Refresh both token */
    public function refresh(?string $refresh_token)
    {
        if (!$refresh_token) {
            throw new AuthException('Invalid Refresh Token', 401);  // If no refresh token received
        }

        $user = $this->authRepository->validateToken($refresh_token);

        if (!$user) {
            throw new AuthException('Invalid Refresh Token', 401);  // if  refresh token is invalid or expired
        }

        $access_token = JWTAuth::fromUser($user);
        $new_refresh_token = Str::random(64);

        $this->authRepository->createNewRefreshToken($user->id, $refresh_token, $new_refresh_token);

        return [
            'token' => $access_token,
            'expires_in' => JWTAuth::factory()->getTTL(),
            'refresh_token' => $new_refresh_token,
            'refresh_token_expiry' => 7 * 24 * 60
        ];
    }
}
