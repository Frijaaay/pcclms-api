<?php

namespace App\Repositories;

use App\Contracts\Repositories\ReturnRepositoryInterface;
use App\Models\BorrowedBook;
use App\Models\ReturnedBook;
use Illuminate\Database\Eloquent\Collection;

class ReturnRepository extends BaseRepository implements ReturnRepositoryInterface
{
    public function __construct(ReturnedBook $model)
    {
        parent::__construct($model);
    }

    public function all(): Collection
    {
        return $this->model
            ->join('borrowed_books', 'returned_books.borrowed_book_id', '=', 'borrowed_books.id')
            ->join('book_copies', 'borrowed_books.book_copy_id', '=', 'book_copies.id')
            ->join('books', 'book_copies.book_id', '=', 'books.id')
            ->join('users as borrower', 'borrowed_books.borrower_id', '=', 'borrower.id')
            ->join('users as librarian', 'returned_books.librarian_id', '=', 'librarian.id')
            ->select(
                'returned_books.*',
                'books.title as book_title',
                'books.author as book_author',
                'borrowed_books.due_at as due_at',
                'borrower.name as borrower_name',
                'borrower.id_number as borrower_id',
                'librarian.name as librarian_name',
                'librarian.id_number as librarian_id'
            )->get();
    }
}
