<?php

namespace App\Repositories;

use App\Contracts\Repositories\BookRepositoryInterface;
use App\Models\Book;

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

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function updateBookById(int $id, array $updatedData)
    {

    }

    public function deleteBookById(int $id)
    {

    }
}
