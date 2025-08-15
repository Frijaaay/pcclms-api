<?php

namespace App\Contracts\Services;

interface UserServiceInterface
{
    public function getAllLibrarians();

    public function getAllBorrowers();

    public function store(array $userData);

    public function update(string $id, array $updatedUser);

    public function delete(string $id);
}
