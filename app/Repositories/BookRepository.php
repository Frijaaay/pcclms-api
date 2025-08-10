<?php

namespace App\Repositories;

use App\Models\Book;

class BookRepository
{
    private Book $model;

    public function __construct(Book $model)
    {
        $this->model = $model;
    }

    public function getAllBooks()
    {
        return $this->model->all();
    }

    public function create(array $data)
    {

    }

    public function updateById(int $id, array $updatedData)
    {

    }

    public function deleteById(int $id)
    {

    }
}
