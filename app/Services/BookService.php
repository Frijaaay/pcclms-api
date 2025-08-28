<?php

namespace App\Services;

use App\Contracts\Repositories\BookRepositoryInterface;
use App\Contracts\Services\BookServiceInterface;
use Exception;

class BookService implements BookServiceInterface
{
    /**
     * Dependency Injection
     */
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * Get all books method
     */
    public function getAllBooks()
    {
        $data = $this->bookRepository->all();

        return [
            'message' => 'Books Retrieved Successfully',
            'book_count' => count($data),
            'books' => $data->sortBy('status')->values()
        ];
    }

    /**
     * Get book by id
     */
    public function getBookById(int $id)
    {
        $data = $this->bookRepository->find($id);

        return [
            'message' => 'Book Retrieved Successfully',
            'book' => $data
        ];
    }

    /**
     * Get book copies
     */
    public function getBookCopies(int $id)
    {
        $data = $this->bookRepository->findBookCopies($id);

        return [
            'message' => 'Book Copies Retrieved Successfully',
            'book_copies' => $data
        ];
    }

    /**
     * Create book
     */
    public function createBook(array $data)
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

        $data = $this->bookRepository->create($book_data, $book_copies_count);

        return [
            'message' => 'Book Created Successfully',
            'book' => $data
        ];
    }

    /**
    * Create Book Copy
    */
    public function createBookCopy(int $id, array $data)
    {
        $book_copies_count = $data['book_copies_count'];

        $data = $this->bookRepository->createBookCopy($id, $book_copies_count);

        return [
            'message' => 'Added ' . $book_copies_count . ' copies successfully',
            'book' => $data
        ];
    }

    /**
     * Update Book
     */
    public function updateBook(int $id, array $updatedData)
    {
        $data = $this->bookRepository->update($id, $updatedData);

        return [
            'message' => 'Book Updated Successfully',
            'book' => $data
        ];
    }

    /**
     * Update Book Copy
     */
    public function updateBookCopy(int $id, int $copy_id, array $updatedData)
    {
        $data = $this->bookRepository->updateBookCopy($id, $copy_id, $updatedData);

        return [
            'message' => 'Book copy updated successfully',
            'book_copy' => $data
        ];
    }

    public function deleteBook(int $id)
    {
        if (!$this->bookRepository->delete($id)) {
            throw new Exception('Deleting failed', 500);
        }

        return [
            'message' => 'Book Deleted Successfully'
        ];
    }
}
