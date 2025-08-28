<?php

namespace App\Repositories;

use App\Contracts\Repositories\BookRepositoryInterface;
use App\Models\Book;
use App\Models\BookCopy;

class BookRepository implements BookRepositoryInterface
{
    /** Dependency injection */
    private Book $model;
    private BookCopy $modelCopy;
    public function __construct(Book $model, BookCopy $modelCopy)
    {
        $this->model = $model;
        $this->modelCopy = $modelCopy;
    }

    /** Select all books */
    public function all()
    {
        return $this->model->withCount('availableBookCopies')->get();
    }

    /** Select book by id */
    public function find(int $id)
    {
        return $this->model->withCount('availableBookCopies')->findOrFail($id);
    }

    /** Select book copies */
    public function findBookCopies(int $id)
    {
        return $this->model->with('bookCopies')->findOrFail($id)->bookCopies;
    }

    /** Create a book with book copies */
    public function create(array $bookData, int $book_copies_count)
    {
        $book = $this->model->create($bookData);    // Creates a model

        $book_copies = [];  // Prepare empty array

        for ($i = 0; $i < $book_copies_count; $i++) {
            $book_copies[] = [
                'book_id' => $book->id,
                'condition' => 'Good'
            ];
        }
        $book->bookCopies()->createMany($book_copies);

        return $book->loadCount('availableBookCopies');
    }

    /** Create a book copy */
    public function createBookCopy(int $id, int $book_copies_count)
    {
        $book = $this->model->findOrFail($id);

        $book_copies = [];

        for ($i = 0; $i < $book_copies_count; $i++) {
            $book_copies[] = [
                'book_id' => $book->id,
                'condition' => 'Good',
            ];
        }
        $book->bookCopies()->createMany($book_copies);

        return $book->loadCount('availableBookCopies');
    }

    /** Update book */
    public function update(int $id, array $updatedData)
    {
        $book = $this->model->findOrFail($id);
        $book->update($updatedData);

        return $book->refresh();
    }

    /** Update book copy */
    public function updateBookCopy(int $id, int $copy_id, array $updatedData)
    {

        $book = $this->model->findOrFail($id);
        $bookCopy = $book->bookCopies()->findOrFail($copy_id);
        $bookCopy->update($updatedData);

        return $bookCopy->refresh();

    }

    /** Delete book */
    public function delete(int $id)
    {
        return $this->model->findOrFail($id)->delete();
    }

}
