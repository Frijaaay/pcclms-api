<?php

namespace App\Repositories;

use App\Contracts\Repositories\ReturnRepositoryInterface;
use App\Models\BorrowedBook;
use App\Models\ReturnedBook;

class ReturnRepository implements ReturnRepositoryInterface
{
    /** Dependency Injection */
    private ReturnedBook $model;
    public function __construct(ReturnedBook $model)
    {
        $this->model = $model;
    }

    /** Stores return record */
    public function store(array $data)
    {
        return $this->model->create($data);
    }
}
