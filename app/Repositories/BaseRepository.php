<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected readonly Model $model) {}

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function findById(mixed $id): ?Model
    {
        return $this->model->findOrFail($id);
    }

    public function store(array $data): ?Model
    {
        return $this->model->create($data);
    }

    public function update(mixed $id, array $data): ?Model
    {
        $model = $this->model->find($id);

        if (!$model) {
            return null;
        }

        $model->update($data);

        return $model;
    }

    public function delete(mixed $id): ?Bool
    {
        $model = $this->model->find($id);

        if (!$model) {
            return false;
        }

        if ($model->delete()) {
            return null;
        }

        return false;
    }

}
