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
        $data = $this->bookRepository->create($data);

        return [
            'message' => 'Book Created Successfully',
            'book' => $data
        ];
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
