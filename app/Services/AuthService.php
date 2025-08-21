<?php

namespace App\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use App\Exceptions\AuthException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Exceptions\EmailUnverifiedException;
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
        $token = auth()->attempt($credentials); // Attempts to validate the user and returns a token

        if(!$token) {
            throw new AuthException();  // If above code fails then throw an error
        }

        $user = auth()->user(); // Gets the currently authenticated user

        if (is_null($user->email_verified_at)) {    // Checks if the user email is not verified then throw an error
            throw new EmailUnverifiedException();
        }

        $refresh_token = Str::random(64);   // Generate Refresh Token
        $hashed_refresh_token = hash('sha256', $refresh_token); // Create a hashed version of Refresh Token
        $expiry = Carbon::now()->addDays(7);    // Set expiration of refresh token into 7 Days
        $this->authRepository->storeRefreshToken($user->id, $hashed_refresh_token, $expiry);    // Calls the repository class and store method and passes the data for database storing

        return [
            'message' => 'Login is successful',
            'token' => [
                'type' => 'Bearer',
                'value' => $token,
                'expires_in' => JWTAuth::factory()->getTTL()
            ],
            'user' => $user,
            'refresh_token' => $refresh_token,
            'refresh_token_expiry' => 60 * 24 * 7
        ];
    }
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
    public function logout(?string $refresh_token)
    {
            JWTAuth::invalidate(Auth::getToken());
            auth()->logout();

            $this->authRepository->revokeToken($refresh_token);

            return ['message' => 'Successfully logged out'];
    }

    public function refresh(?string $refresh_token)
    {
        if (!$refresh_token) {
            throw new Exception('Invalid Refresh Token', 401);  // If no refresh token received
        }

        $user = $this->authRepository->validateToken(hash('sha256', $refresh_token)); // Gets the user model appointed with refresh token

        if (!$user) {
            throw new Exception('Invalid Refresh Token', 401);  // if  refresh token is invalid
        }

        $token = JWTAuth::fromUser($user); // Generates new access token

        $new_refresh_token = Str::random(64);   //Generates new refresh token
        $this->authRepository->storeNewRefreshToken($user->id, $refresh_token, $new_refresh_token);

        return [
            'token' => $token,
            'expires_in' => JWTAuth::factory()->getTTL(),
            'refresh_token' => $new_refresh_token,
            'refresh_token_expiry' => 7 * 24 * 60
        ];
    }
}
