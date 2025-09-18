<?php

namespace App\Contracts\Repositories;

use App\Models\BorrowedBook;

interface ReturnRepositoryInterface
{
    public function store(array $data);

}
