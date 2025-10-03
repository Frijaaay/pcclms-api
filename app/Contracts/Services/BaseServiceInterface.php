<?php

namespace App\Contracts\Services;

interface BaseServiceInterface
{
    public function getAll();
    public function getById(mixed $id);
    public function create(array $data);
    public function update(mixed $id, array $data);
    public function delete(mixed $id);


}
