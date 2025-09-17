<?php

namespace App\Contracts\Repositories;

interface BorrowRepositoryInterface
{
    public function getBorrowed(string $id);

    public function store(array $data);
}
