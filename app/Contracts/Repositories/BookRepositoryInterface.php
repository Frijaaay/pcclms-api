<?php

namespace App\Contracts\Repositories;

interface BookRepositoryInterface
{
    public function all();

    public function find(int $id);

    public function findBookCopies(int $id);

    public function create(array $bookData, int $book_copies_count);

    public function createBookCopy(int $id, int $book_copies_count);

    public function update(int $id, array $updatedData);

    public function updateBookCopy(int $id, int $copy_id, array $updatedData);

    public function delete(int $id);

}
