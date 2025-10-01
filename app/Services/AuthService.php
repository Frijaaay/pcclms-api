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
    /**
     * Constructor Property Promotion
     */
    public function __construct(private AuthRepositoryInterface $authRepository) {}

    /** Create a refresh token */
    private function createRefreshToken(string $user_id)
    {
        $refresh_token = Str::random(64);
        $expires_at = Carbon::now()->addDays(7);

        $data = [
            'user_id' => $user_id,
            'token' => hash('sha256',$refresh_token),
            'expires_at' => $expires_at
        ];

        if (!$this->authRepository->store($data)) {
            throw new AuthException('Internal Server Error', 500);
        }

        return [
            'value' => $refresh_token,
            'expires_at' => now()->diffInMinutes($expires_at)
        ];
    }

    /** Validate a refresh token */
    private function validateRefreshToken(?string $refresh_token)
    {
        // If no refresh token received
        if (!$refresh_token) {
            throw new AuthException('Invalid Refresh Token', 401);
        }
        // if  refresh token is invalid or expired
        $user = $this->authRepository->validateToken($refresh_token);
        if (!$user) {
            throw new AuthException('Invalid Refresh Token', 401);
        }

        return $user;
    }

    /** Logins the user and issues the tokens*/
    public function login(array $credentials)
    {
        // Attempts to login the credentials given and get a access token
        $access_token = JWTAuth::attempt($credentials);

        // If login failed, throw an exception
        if(!$access_token) {
            throw new AuthException();
        }

        // Get the authenticated user
        $authUser = auth()->user();

        // Checks if the user is verified
        if (is_null($authUser->email_verified_at)) {
            throw new EmailUnverifiedException();
        }

        // Generate a refresh token
        $refresh_token = $this->createRefreshToken($authUser->id);

        return [
            'message' => 'Login is successful',
            'data' => [
                'token' => [
                    'type' => 'Bearer',
                    'value' => $access_token,
                    'expires_in' => JWTAuth::factory()->getTTL() * 60
                ],
                'user' => $authUser->load('userType'),
            ],
            'refresh_token' => $refresh_token['value'],
            'refresh_token_expiry' => $refresh_token['expires_at']
        ];
    }

    /** Refresh both token */
    public function refresh(?string $refresh_token)
    {
        // Call refresh token validator
        $user = $this->validateRefreshToken($refresh_token);
        // Get new access token from user
        $access_token = JWTAuth::fromUser($user);
        // Generate new refresh token
        $new_refresh_token = Str::random(64);

        $data = [
            'old_token' => hash('sha256', $refresh_token),
            'new_token' => [
                'token' => hash('sha256', $new_refresh_token),
                'expires_at' => now()->addDays(7),
                'revoked' => false
                ]
        ];
        // Rotates the refresh token
        $this->authRepository->update($user->id, $data);

        return [
            'message' => 'Token refreshed',
            'data' => [
                'token' => [
                    'type' => 'Bearer',
                    'value' => $access_token,
                    'expires_in' => JWTAuth::factory()->getTTL() * 60
                ],
            ],
            'refresh_token' => $new_refresh_token,
            'refresh_token_expiry' => 7 * 24 * 60
        ];
    }

    /** Get the authenticated user and issue a new access token */
    public function hydrate(?string $refresh_token)
    {
            $user = auth()->user();

            if(!$user) {
                throw new AuthException();
            }

            $new_access_token = JWTAuth::refresh(true, true);

            return [
                'message' => 'Hydrated',
                'data' => [
                    'token' => [
                        'type' => 'Bearer',
                        'value' => $new_access_token,
                        'expires_in' => JWTAuth::factory()->getTTL() * 60
                    ],
                    'user' => $user
                ],
            ];
    }

    /** Logouts user and invalidates both access and refresh token */
    public function logout(?string $refresh_token)
    {
        // Revokes Refresh Token
        $this->authRepository->revokeToken(hash('sha256', $refresh_token));

        // Invalidates access token and logouts user
        auth()->logout();

        return 'Successfully logged out';
    }

}
