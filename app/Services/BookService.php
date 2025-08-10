<?php

namespace App\Services;

use App\Contracts\Repositories\BookRepositoryInterface;

class BookService
{
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function all()
    {
        return $this->bookRepository->getAllBooks();
    }

    public function store(array $data)
    {
        return $this->bookRepository->create($data);
    }

    public function update(int $id, array $updatedData)
    {
        return $this->bookRepository->updateBookById($id, $updatedData);
    }

    public function delete(int $id)
    {
        return $this->bookRepository->deleteBookById($id);
    }
}
