<?php

namespace App\Contracts\Repositories;

interface ReportRepositoryInterface
{
    public function all();
    public function findById(mixed $id);
    public function findByBorrowerId(string $id);
}
