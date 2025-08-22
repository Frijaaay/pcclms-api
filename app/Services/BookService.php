<?php

namespace App\Services;

use App\Contracts\Repositories\BookRepositoryInterface;
use App\Contracts\Services\BookServiceInterface;

class BookService implements BookServiceInterface
{
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function all()
    {
        $data = $this->bookRepository->getAllBooks();
        return [
            'message' => 'Books Retrieved Successfully',
            'book_count' => count($data),
            'books' => $data->sortBy('status')->values()
        ];
    }

    public function store(array $data)
    {
        $bookData = [
            'title' => $data['title'],
            'author' => $data['author'],
            'author_1' => $data['author_1'],
            'author_2' => $data['author_2'],
            'author_3' => $data['author_3'],
            'isbn' => $data['isbn'],
            'category' => $data['category'],
        ];
        $book_copies_count = $data['book_copies_count'] ?? 0;

        $book = $this->bookRepository->create($bookData, $book_copies_count);

        return [
            'message' => 'Book Created Successfully',
            'book' => $book
        ];
    }

    public function addCopy(int $id, $book_copies_count)
    {
        $book_copies_count = $book_copies_count['book_copies_count'];

        return $this->bookRepository->createCopy($id, $book_copies_count);
    }

    public function update(int $id, array $updatedData)
    {
        $data = $this->bookRepository->updateBookById($id, $updatedData);

        return [
            'message' => 'Book Updated Successfully',
            'book' => $data
        ];
    }

    public function delete(int $id)
    {
        $this->bookRepository->deleteBookById($id);

        return [
            'message' => 'Book Deleted Successfully'
        ];
    }
}
