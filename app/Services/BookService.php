<?php

namespace App\Services;

use App\Contracts\Repositories\BookRepositoryInterface;
use App\Contracts\Services\BookServiceInterface;
use Exception;

class BookService extends BaseService implements BookServiceInterface
{
    /**
     * Dependency Injection
     */
    public function __construct(BookRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Create book
     */
    public function create(array $data): Array
    {
        $book_data = [
            'title' => $data['title'],
            'author' => $data['author'],
            'author_1' => $data['author_1'],
            'author_2' => $data['author_2'],
            'author_3' => $data['author_3'],
            'isbn' => $data['isbn'],
            'category' => $data['category'],
        ];

        $book_copies_count = $data['book_copies_count'] ?? 0;

        $data = $this->repository->create($book_data, $book_copies_count);

        return $this->serviceArrayReturn($data, 'Book Created Successfully');
    }

    /**
    * Create Book Copy
    */
    public function createBookCopy(int $id, array $data)
    {
        $book_copies_count = $data['book_copies_count'];
        $data = $this->repository->createBookCopy($id, $book_copies_count);
        return $this->serviceArrayReturn($data, "Added {$book_copies_count} copies successfully");
    }

    /**
     * Update Book Copy
     */
    public function updateBookCopy(int $id, int $copy_id, array $updatedData)
    {
        $data = $this->repository->updateBookCopy($id, $copy_id, $updatedData);
        return $this->serviceArrayReturn($data, 'Book copy updated successfully');
    }

    public function deleteBook(int $id)
    {
        if (!$this->repository->delete($id)) {
            throw new Exception('Deleting failed', 500);
        }

        return [
            'message' => 'Book Deleted Successfully'
        ];
    }
}
