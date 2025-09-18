<?php

namespace App\Repositories;

use App\Contracts\Repositories\BorrowRepositoryInterface;
use App\Models\BookCopy;
use App\Models\BorrowedBook;

class BorrowRepository implements BorrowRepositoryInterface
{
    /** Dependency Injection */
    private BorrowedBook $model;
    public function __construct(BorrowedBook $borrowedBook, BookCopy $bookCopy)
    {
        $this->model = $borrowedBook;
    }


    /** Get borrow record */
    public function getById(string $id)
    {
        return $this->model->find($id);
    }

    /** Get number of borrowed books by user */
    public function getBorrowed(string $id)
    {
        return $this->countActiveBorrows($id);
    }

    /** Stores a borrow book record */
    public function store(array $data)
    {
        return $this->model->create($data);
    }

    /** Handles checking the number of borrowed books by user */
    private function countActiveBorrows(string $id)
    {
        return $this->model->whereBorrowerId($id)->whereDoesntHave('returnRecord')->count();
    }
}
