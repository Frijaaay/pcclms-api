<?php

namespace App\Contracts\Repositories;

use Carbon\Carbon;

interface AuthRepositoryInterface
{
    public function storeRefreshToken(string $id, string $refresh_token, Carbon $expiry);

    public function validateToken(string $token);

    public function storeNewRefreshToken(string $id, string $refresh_token, string $new_refresh_token);

    public function revokeToken(?string $refresh_token);
}
