<?php

namespace App\Contracts\Services;

interface AuthServiceInterface
{
    public function login(array $credentials);

    public function hydrate();

    public function logout();

}
