<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function all();
    public function findById(mixed $id);
    public function store(array $data);
    public function update(mixed $id, array $data);
    public function delete(mixed $id);
}
