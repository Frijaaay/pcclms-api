<?php

namespace App\Repositories;

use App\Contracts\Repositories\ReportRepositoryInterface;
use App\Models\BorrowedBook;
use App\Models\ReturnedBook;
use Illuminate\Database\Eloquent\Collection;

class ReportRepository implements ReportRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private BorrowedBook $borrowedBook, private ReturnedBook $returnedBook) {}


    /**
     * Retrieves all transactions
     */
    public function all(): Collection
    {
        $reports = $this->borrowedBook
            ->join('book_copies', 'borrowed_books.book_copy_id', '=', 'book_copies.id')
            ->join('books', 'book_copies.book_id', '=', 'books.id')
            ->join('users as borrower', 'borrowed_books.borrower_id', '=', 'borrower.id')
            ->join('users as librarian', 'borrowed_books.librarian_id', '=', 'librarian.id')
            ->leftJoin('returned_books', 'borrowed_books.id', '=', 'returned_books.borrowed_book_id')
            ->select(
                'borrowed_books.id',
                'books.title',
                'books.author',
                'borrower.name as borrower_name',
                'librarian.name as librarian_name',
                'borrowed_books.borrowed_at',
                'borrowed_books.due_at',
                'returned_books.returned_at',
                'returned_books.returned_condition',
                'returned_books.penalty',
                )->get();

        return $reports;
    }
}
