<?php

namespace App\Contracts\Services;

interface BookServiceInterface
{
    public function getAllBooks();

    public function getBookById(int $id);

    public function getBookCopies(int $id);

    public function createBook(array $data);

    public function createBookCopy(int $id, array $data);

    public function updateBook(int $id, array $updatedData);

    public function updateBookCopy(int $id, int $copy_id, array $updatedData);

    public function deleteBook(int $id);
}
