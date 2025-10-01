<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\User;
use App\Models\RefreshToken;
use App\Contracts\Repositories\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    /**
     * Constructor Property Promotion
     */
    public function __construct(private RefreshToken $rToken, private User $model) {}

    /**
      * Stores the refresh token
      */
    public function storeRefreshToken(string $id, string $refresh_token, Carbon $expires_at)
    {
        return $this->rToken->create([
            'user_id' => $id,
            'token' => $refresh_token,
            'expires_at' => $expires_at
        ]);
    }

    /** validates refresh token */
    public function validateToken(string $refresh_token)
    {
        $hashed_refresh_token = hash('sha256', $refresh_token);

        $valid_refresh_token = $this->rToken->with('user')->where('token', $hashed_refresh_token)
            ->where('revoked', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$valid_refresh_token) {
            $this->revokeToken($refresh_token);
            return false;
        }

        return $valid_refresh_token?->user;
    }

    /** Update refresh token*/
    public function createNewRefreshToken(string $id, string $refresh_token, string $new_refresh_token)
    {
        $refresh_token = hash('sha256', $refresh_token);
        $new_refresh_token = hash('sha256', $new_refresh_token);

        $this->rToken->where('user_id', $id)->where('token', $refresh_token)->update([
            'token' => $new_refresh_token,
            'expires_at' => now()->addDays(7),
            'revoked' => false
        ]);
    }

    /** Revokes token */
    public function revokeToken(?string $refresh_token)
    {
        return $this->rToken->where('token', hash('sha256', $refresh_token))
            ->update(['revoked' => true]) > 0;
    }

}
