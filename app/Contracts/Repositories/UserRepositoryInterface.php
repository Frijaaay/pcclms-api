<?php

namespace App\Contracts\Repositories;

interface UserRepositoryInterface
{
    public function selectAllLibrarians();

    public function selectAllBorrowers();

    public function createUser(array $data);

    public function updateUserById(int $id, array $data);

    public function deleteUserById(int $id);
}
