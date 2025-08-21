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

    public function storeRefreshToken(string $id, string $refresh_token, Carbon $expiry)
    {
        return $this->rToken->create([
            'user_id' => $id,
            'token' => $refresh_token,
            'expires_at' => $expiry
        ]);
    }

    public function validateToken(string $token)
    {
        $refresh_token = $this->rToken->with('user')->where('token', $token)
            ->where('revoked', false)
            ->where('expires_at', '>', now())
            ->firstOrFail();

        return $refresh_token?->user;
    }

    public function storeNewRefreshToken(string $id, string $refresh_token, string $new_refresh_token)
    {
        $refresh_token = hash('sha256', $refresh_token);
        $new_refresh_token = hash('sha256', $new_refresh_token);

        $this->rToken->where('user_id', $id)->where('token', $refresh_token)->update([
            'token' => $new_refresh_token,
            'expires_at' => now()->addDays(7),
            'revoked' => false
        ]);
    }

    public function revokeToken(?string $refresh_token)
    {
        return $this->rToken->where('token', hash('sha256', $refresh_token))
            ->update(['revoked' => true]) > 0;
    }

}
