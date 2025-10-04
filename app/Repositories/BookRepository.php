<?php

namespace App\Repositories;

use App\Models\Book;
use App\Models\BookCopy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Repositories\BookRepositoryInterface;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    public function __construct(Book $model, private BookCopy $modelCopy)
    {
        parent::__construct($model);
    }

    /** Select all books */
    public function all(): Collection
    {
        return $this->model->withCount('availableBookCopies')->get();
    }

    /** Select book by id */
    public function findById(mixed $id): ?Model
    {
        return $this->model->withCount('availableBookCopies')->findOrFail($id);
    }

    /** Select book with its available copies */
    public function findBookCopies(int $id)
    {
        return $this->model->select(['id', 'title', 'author'])->with('availableBookCopies')->findOrFail($id);
    }

    /** Select book copy */
    public function findBookCopy(int $id)
    {
        return $this->modelCopy->findOrFail($id);
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

    /** Update book copy */
    public function updateBookCopy(int $id, int $copy_id, array $updatedData)
    {

        $book = $this->model->findOrFail($id);
        $bookCopy = $book->bookCopies()->findOrFail($copy_id);
        $bookCopy->update($updatedData);

        return $bookCopy->refresh();

    }

    /** Handles checking if book copy is available */
    public function isBookAvailable(int $book_copy_id)
    {
        return $this->modelCopy->where('status', 'Available')->find($book_copy_id);
    }

    /** Handles book copy status and condition */
    public function updateBookCopyStatus(int $id, ?string $condition = null)
    {
        $book_copy = $this->modelCopy->findOrFail($id);

        if ($condition === null) {
            $condition = $book_copy->condition;
            $status = 'Borrowed';
        } else {
            $status = $this->determineStatus($condition);
        }

        $book_copy->update([
            'status' => $status,
            'condition' => $condition
        ]);

        return $book_copy;
    }

    protected function determineStatus(string $condition)
    {
        return in_array($condition, ['Good', 'Slightly Damaged'])
            ? 'Available'
            : 'Unavailable';
    }
}
