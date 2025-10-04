<?php

namespace App\Repositories;

use App\Contracts\Repositories\BorrowRepositoryInterface;
use App\Models\BookCopy;
use App\Models\BorrowedBook;
use Illuminate\Database\Eloquent\Collection;

class BorrowRepository extends BaseRepository implements BorrowRepositoryInterface
{
    public function __construct(BorrowedBook $model, BookCopy $bookCopy)
    {
        parent::__construct($model);
    }

    public function all(): Collection
    {
        return $this->model
            ->join('book_copies', 'borrowed_books.book_copy_id', '=', 'book_copies.id')
            ->join('books', 'book_copies.book_id', '=', 'books.id')
            ->join('users as borrower', 'borrowed_books.borrower_id', '=', 'borrower.id')
            ->join('users as librarian', 'borrowed_books.librarian_id', '=', 'librarian.id')
            ->select(
                'borrowed_books.*',
                'books.title as book_title',
                'books.author as book_author',
                'book_copies.condition as book_condition',
                'borrower.name as borrower_name',
                'borrower.id_number as borrower_id',
                'librarian.name as librarian_name',
                'librarian.id_number as librarian_id',
            )->get();
    }

    public function findByBorrowerId(string $id): ?Collection
    {
        return $this->model->whereBorrowerId($id)->get();
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
