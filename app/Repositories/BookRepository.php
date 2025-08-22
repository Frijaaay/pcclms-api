<?php

namespace App\Repositories;

use App\Contracts\Repositories\BookRepositoryInterface;
use App\Models\Book;
use App\Models\BookCopy;

class BookRepository implements BookRepositoryInterface
{
    private Book $model;
    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    public function getAllBooks()
    {
        return $this->model->withCount('bookCopies')->get();
    }

    /**
     * Create a new book and its copies.
     *
     * @param array $bookData Data for creating the book.
     * @param int $book_copies_count Number of book copies to create.
     * @return \App\Models\Book The created book model with bookCopies count loaded.
     */
    public function create(array $bookData, int $book_copies_count)
    {
        $book = $this->model->create($bookData);    // Creates a model

        $book_copies = [];  // Prepare empty array

        for ($i = 0; $i < $book_copies_count; $i++) {
            $book_copies[] = [
                'book_id' => $book->id,
                'status' => 'Available',
                'condition' => 'New'
            ];
        }
        $book->bookCopies()->createMany($book_copies);

        return $book->loadCount('bookCopies');
    }

    public function createCopy(int $id, $book_copies_count)
    {
        $book = $this->model->findOrFail($id);

        $book_copies = [];

        for ($i = 0; $i < $book_copies_count; $i++) {
            $book_copies[] = [
                'book_id' => $book->id,
                'status' => 'Available',
                'condition' => 'New'
            ];
        }
        $book->bookCopies()->createMany($book_copies);

        return $book->loadCount('bookCopies');
    }

    public function updateBookById(int $id, array $updatedData)
    {
        $this->model->where('id', $id)->update($updatedData);

        return $this->model->findOrFail($id);
    }

    public function deleteBookById(int $id)
    {
        return $this->model->findOrFail($id)->delete();
    }
}
