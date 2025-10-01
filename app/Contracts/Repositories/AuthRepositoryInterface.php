<?php

namespace App\Contracts\Repositories;

interface AuthRepositoryInterface extends BaseRepositoryInterface
{
    public function validateToken(string $refresh_token);
    public function revokeToken(?string $refresh_token);
}
