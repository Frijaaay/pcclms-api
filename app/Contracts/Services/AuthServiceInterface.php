<?php

namespace App\Contracts\Services;

interface AuthServiceInterface
{
    public function login(array $credentials);
    public function refresh(?string $refresh_token);
    public function hydrate(?string $refresh_token);
    public function logout(?string $refresh_token);

}
