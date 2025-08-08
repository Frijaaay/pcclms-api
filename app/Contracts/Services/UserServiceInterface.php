<?php

namespace App\Contracts\Services;

interface UserServiceInterface
{
    public function getAllUsers();

    public function store(array $userData);
}
