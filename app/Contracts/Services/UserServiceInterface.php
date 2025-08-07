<?php

namespace App\Contracts\Services;

interface UserServiceInterface
{
    public function all();

    public function store(array $userData);
}
