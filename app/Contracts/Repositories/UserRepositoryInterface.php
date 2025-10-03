<?php

namespace App\Contracts\Repositories;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function findAllLibrarians();
    public function findAllBorrowers();
    public function validateEmailToken(string $id, $email_token);
}
