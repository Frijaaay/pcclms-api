<?php

namespace App\Repositories;

use App\Models\RefreshToken;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\Repositories\AuthRepositoryInterface;

class AuthRepository extends BaseRepository implements AuthRepositoryInterface
{
    /**
     * Constructor Property Promotion
     */
    public function __construct(RefreshToken $model)
    {
        parent::__construct($model);
    }

    /** Validates refresh token */
    public function validateToken(string $refresh_token)
    {
        $hashed_refresh_token = hash('sha256', $refresh_token);

        $valid_refresh_token = $this->model->with('user')->where('token', $hashed_refresh_token)
            ->where('revoked', false)
            ->where('expires_at', '>', now())
            ->first();

        if (!$valid_refresh_token) {
            $this->revokeToken($refresh_token);
            return false;
        }

        return $valid_refresh_token?->user;
    }

    /** rotates refresh token*/
    public function update(mixed $id, array $data): ?Model
    {
        $model = $this->model->where('user_id', $id)->where('token', $data['old_token'])->first();

        if (!$model) {
            return null;
        }

        $model->update($data['new_token']);

        return $model;
    }

    /** Revokes token */
    public function revokeToken(?string $refresh_token)
    {
        return $this->model->where('token', $refresh_token)
            ->update(['revoked' => true]) > 0;
    }
}
