<?php

namespace App\Contracts\Services;

interface BookServiceInterface extends BaseServiceInterface
{
    public function getBookCopies(int $id);
    public function getBookCopyById(int $id);
    public function createBookCopy(int $id, array $data);
    public function updateBookCopy(int $id, int $copy_id, array $updatedData);
}
