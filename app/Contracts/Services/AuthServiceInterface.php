<?php

namespace App\Contracts\Services;

interface AuthServiceInterface
{
    public function login(array $credentials);

    public function hydrate(string $token);

    public function logout(string $token);
}
