<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\RefreshToken;
use App\Exceptions\AuthException;
use App\Contracts\Repositories\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    private RefreshToken $rToken;
    private User $model;

    public function __construct(RefreshToken $rToken, User $model)
    {
        $this->rToken = $rToken;
        $this->model = $model;
    }

    public function createRToken(string $id, string $hashedRToken, Carbon $expiry)
    {
        return $this->rToken->create([
            'user_id' => $id,
            'token' => $hashedRToken,
            'expires_at' => $expiry
        ]);
    }

    public function validateToken(string $token)
    {
        return $this->rToken->where('token', hash('sha256', $token))
            ->where('revoked', false)
            ->where('expires_at', '>', now())
            ->first();
    }

    public function revokeToken(string $token)
    {
        return $this->rToken->where('token', hash('sha256', $token))
            ->update(['revoked' => true]) > 0;
    }

}
