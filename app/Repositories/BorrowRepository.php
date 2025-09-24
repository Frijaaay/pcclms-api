<?php

namespace App\Repositories;

use App\Contracts\Repositories\BorrowRepositoryInterface;
use App\Models\BookCopy;
use App\Models\BorrowedBook;

class BorrowRepository extends BaseRepository implements BorrowRepositoryInterface
{
    public function __construct(BorrowedBook $model, BookCopy $bookCopy)
    {
        parent::__construct($model);
    }

    /** Get number of borrowed books by user */
    public function getBorrowed(string $id)
    {
        return $this->countActiveBorrows($id);
    }

    /** Retrieves all borrowed book records that have not been returned. */
    public function findActiveBorrows()
    {
        return $this->model->whereDoesntHave('returnRecord')->get();
    }

    /** Handles checking the number of borrowed books by user */
    private function countActiveBorrows(string $id)
    {
        return $this->model->whereBorrowerId($id)->whereDoesntHave('returnRecord')->count();
    }
}
