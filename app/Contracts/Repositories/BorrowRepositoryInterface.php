<?php

namespace App\Contracts\Repositories;

interface BorrowRepositoryInterface
{
    public function getById(string $id);

    public function getBorrowed(string $id);

    public function store(array $data);
}
