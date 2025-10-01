<?php

namespace App\Contracts\Repositories;

use Carbon\Carbon;

interface AuthRepositoryInterface
{
    public function storeRefreshToken(string $id, string $refresh_token, Carbon $expires_at);

    public function validateToken(string $refresh_token);

    public function createNewRefreshToken(string $id, string $refresh_token, string $new_refresh_token);

    public function revokeToken(?string $refresh_token);
}
