<?php

namespace App\Repositories;

use App\Contracts\Repositories\ReturnRepositoryInterface;
use App\Models\BorrowedBook;
use App\Models\ReturnedBook;

class ReturnRepository extends BaseRepository implements ReturnRepositoryInterface
{
    public function __construct(ReturnedBook $model)
    {
        parent::__construct($model);
    }
}
