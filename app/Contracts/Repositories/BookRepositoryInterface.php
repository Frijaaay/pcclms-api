<?php

namespace App\Contracts\Repositories;

interface BookRepositoryInterface extends BaseRepositoryInterface
{
    public function findBookCopies(int $id);
    public function findBookCopy(int $id);
    public function createBookCopy(int $id, int $book_copies_count);
    public function updateBookCopy(int $id, int $copy_id, array $updatedData);
    public function updateBookCopyStatus(int $id, ?string $condition = null);
    public function isBookAvailable(int $book_copy_id);
}
