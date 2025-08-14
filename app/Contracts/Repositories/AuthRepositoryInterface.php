<?php

namespace App\Contracts\Repositories;

use Carbon\Carbon;

interface AuthRepositoryInterface
{
    public function createRToken(string $id, string $hashedRToken, Carbon $expiry);

    public function validateToken(string $token);

    public function revokeToken(string $token);
}
