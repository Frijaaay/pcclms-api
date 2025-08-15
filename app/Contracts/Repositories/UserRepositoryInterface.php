<?php

namespace App\Contracts\Repositories;

interface UserRepositoryInterface
{
    public function selectAllLibrarians();

    public function selectAllBorrowers();

    public function createUser(array $data);

    public function updateUserById(string $id, array $data);

    public function deleteUserById(string $id);

    public function verifyEmailToken(string $id, $email_token);
}
