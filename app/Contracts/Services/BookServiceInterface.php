<?php

namespace App\Contracts\Services;

interface BookServiceInterface
{
    public function all();

    public function store(array $data);

    public function update(int $id, array $updatedData);

    public function delete(int $id);

}
