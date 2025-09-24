<?php

namespace App\Contracts\Services;

interface ReturnServiceInterface extends BaseServiceInterface
{
    public function returnBook(array $data);
}
