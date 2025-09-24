<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface ReportRepositoryInterface
{
    public function all();
    public function findById(mixed $id);
    public function findByBorrowerId(string $id);
}
