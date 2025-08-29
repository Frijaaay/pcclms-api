<?php

namespace App\Contracts\Repositories;

use Carbon\Carbon;

interface AuthRepositoryInterface
{
    public function createRefreshToken(string $id, string $refresh_token);

    public function validateToken(string $refresh_token);

    public function createNewRefreshToken(string $id, string $refresh_token, string $new_refresh_token);

    public function revokeToken(?string $refresh_token);
}
