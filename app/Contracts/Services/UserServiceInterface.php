<?php

namespace App\Contracts\Services;

interface UserServiceInterface extends BaseServiceInterface
{
    public function getAllAdmins();
    public function getAllLibrarians();
    public function getAllBorrowers();
    public function email_verification(string $id, $email_token);
}
