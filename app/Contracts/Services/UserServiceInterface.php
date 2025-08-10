<?php

namespace App\Contracts\Services;

interface UserServiceInterface
{
    public function getAllUsers();

    public function store(array $userData);

    public function update(int $id, array $updatedUser);

    public function delete(int $id);
}
