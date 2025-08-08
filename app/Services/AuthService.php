<?php

namespace App\Services;

use Tymon\JWTAuth\Facades\JWTAuth;
use Psy\CodeCleaner\FunctionContextPass;
use SebastianBergmann\CodeUnit\FileUnit;
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
        try {
            $token = JWTAuth::attempt($credentials);

            if(!$token) {
                return [
                    'success' => false,
                    'message' => 'Invalid credentials',
                    'token' => null,
                    'authenticatedUser' => null
                ];
            }
            //else

            $authenticatedUser = JWTAuth::user();

            return [
                'success' => true,
                'message' => 'Login successful',
                'token' => $token,
                'authenticatedUser' => $authenticatedUser
            ];
        } catch (JWTException $e) {
            return [
                'success' => false,
                'message' => 'Could not create token',
                'token' => null,
                'authenticatedUser' => null
            ];
        }
    }
    public function hydrate(string $token)
    {

    }
    public function logout(string $token)
    {

    }
}
