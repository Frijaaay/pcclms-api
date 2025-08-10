<?php

namespace App\Contracts\Repositories;

interface BookRepositoryInterface
{
    public function getAllBooks();

    public function create(array $data);

    public function updateBookById(int $id, array $updatedData);

    public function deleteBookById(int $id);
}
