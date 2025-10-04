<?php

namespace App\Contracts\Repositories;

interface BorrowRepositoryInterface extends BaseRepositoryInterface
{
    public function getBorrowed(string $id);
    public function findActiveBorrows();
    public function findByBorrowerId(string $id);
}
