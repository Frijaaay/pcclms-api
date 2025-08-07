<?php

namespace App\Contracts\Repositories;

interface UserRepositoryInterface
{
    public function create(array $data);

    public function all();
}
