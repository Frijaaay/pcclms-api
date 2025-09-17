<?php

namespace App\Repositories;

use App\Contracts\Repositories\BorrowRepositoryInterface;
use App\Models\BookCopy;
use App\Models\BorrowedBook;

class BorrowRepository implements BorrowRepositoryInterface
{
    /** Dependency Injection */
    private BorrowedBook $model;
    private BookCopy $bookCopy;
    public function __construct(BorrowedBook $borrowedBook, BookCopy $bookCopy)
    {
        $this->model = $borrowedBook;
        $this->bookCopy = $bookCopy;
    }

    /** Handles checking if book copy is available */
    private function isBookAvailable(int $book_copy_id)
    {
        return $this->bookCopy->where('status', 'Available')->find($book_copy_id);
    }

    /** Handles checking the number of borrowed books by user */
    private function countActiveBorrows(string $id)
    {
        return $this->model->whereBorrowerId($id)->whereDoesntHave('returnRecord')->count();
    }

    public function getBorrowed(string $id)
    {
        return $this->countActiveBorrows($id);
    }

    /** Creates a borrow book record */
    public function store(array $data)
    {
        $bookCopy = $this->isBookAvailable($data['book_copy_id']);

        if (!$bookCopy) {
            return false;
        }
        $bookCopy->update(['status' => 'Borrowed']);
        return $this->model->create($data);
    }
}
