<?php

namespace App\Contracts\Repositories;

interface UserRepositoryInterface
{
    public function selectAllUsers();
    public function create(array $data);


}
